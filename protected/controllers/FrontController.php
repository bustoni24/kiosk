<?php

class FrontController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
    {
        return array(
            'accessControl', // tambahkan filter akses
			'postOnly + delete', // we only allow deletion via POST request
            array('application.components.CsrfFilter'), // tambahkan filter csrf untuk semua action
        );
    }

	public function actionIndex()
	{		
		$this->layout = "//layouts/column_front";
		Helper::clearSession();

		$model = new Armada('searchListBus');
		if (isset($_GET['source'])) {
			$model->source_id = $_GET['source'];
		}
		if (isset($_GET['destination'])){
			$model->destination_id = $_GET['destination'];
		}		

		$listTujuan = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$listTujuan = isset($listTujuan['data']) ? $listTujuan['data'] : [];

		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$this->render('index', [
			'listTujuan' => $listTujuan,
			'arrTujuan' => $arrTujuan,
			'model' => $model
		]);
	}

	public function actionHomePage()
	{
		/* $ip = "34.172.237.230";
		$test = ApiHelper::getInstance()->get_geolocation(ApiHelper::getInstance()->apiKeyGeoLoc(), $ip);
		Helper::getInstance()->dump(json_decode($test, true)); */
		// Helper::getInstance()->dump(Yii::app()->session['post_return']);

		if (isset(Yii::app()->session['post_return'])) {
			$_POST = Yii::app()->session['post_return'];
		}
		if (isset(Yii::app()->session['post_seatmap']))
			unset(Yii::app()->session['post_seatmap']);

		if (!isset($_POST['startdate'], $_POST['source_id'], $_POST['destination_id'])) {
			throw new CHttpException(404,'Halaman yang diminta tidak valid. Pastikan Anda telah benar dalam memilih titik keberangkatan, tujuan dan tanggal!');
		}
		
		$model = new Armada('searchListBus');
		$model->startdate = $_POST['startdate'];
		$model->enddate = isset($_POST['enddate']) && !empty($_POST['enddate']) ? $_POST['enddate'] : null;
		$model->source_id = $_POST['source_id'];
		$model->destination_id = $_POST['destination_id'];
		$model->return = isset($_POST['return']) ? $_POST['return'] : 0;

		// Helper::getInstance()->dump($model);

		$listSource = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$arrSource = isset($listSource['data']) ? $listSource['data'] : [];
		if (isset($arrSource[$model->source_id])) {
			$model->source_name = $arrSource[$model->source_id];
		}
		if (isset($arrTujuan[$model->destination_id])) {
			$model->destination_name = $arrTujuan[$model->destination_id];
		}
		$this->render('homepage', [
			'listTujuan' => $arrSource,
			'arrTujuan' => $arrTujuan,
			'model' => $model
		]);
	}

	public function actionSeatmap($id)
	{
		$model = new Booking('seatmap');
		$post = $_POST;
        if (isset($_POST['FormSeat'], $_POST['FormBooking'][Constant::SEARCH_BOARDING])) {
            $post = $_POST['FormBooking'][Constant::SEARCH_BOARDING];
			$countSeatBoarding = 0;
			if (isset($_POST['FormSeat'][Constant::SEARCH_BOARDING]['kursi'])){
				$countSeatBoarding = count($_POST['FormSeat'][Constant::SEARCH_BOARDING]['kursi']);
				$_POST['FormSeat'][Constant::SEARCH_BOARDING]['jml_pnp'] = $countSeatBoarding;
			}

            //set paramPost untuk boarding
            Helper::getInstance()->setState(Constant::TEMP_POST, [
                'FormSeat' => $_POST['FormSeat'],
                'FormBooking' => $_POST['FormBooking'],
            ]);
            if (isset($_POST['proses']) && $_POST['proses'] == 'PILIH KURSI KEPULANGAN') {
				//set session untuk parameter POST
				$post['return'] = 1;
				Yii::app()->session['post_return'] = $post;
                //redirect ke pilih kursi untuk kepulangan
                return $this->redirect(Constant::baseUrl().'/front/homepage');
            }

            //jika sampai sini redirect ke isi identitas
            return $this->redirect(Constant::baseUrl().'/front/fillForm');
        } else if (isset($_POST['FormSeat'], $_POST['FormBooking'][Constant::SEARCH_DROP_OFF])) {
            $post = $_POST['FormBooking'][Constant::SEARCH_DROP_OFF];
            //proses simpan post array untuk drop off
            $this->paramPost = Helper::getInstance()->getState(Constant::TEMP_POST);
            if (isset($this->paramPost['FormSeat'])) {
                $this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF] = $_POST['FormSeat'][Constant::SEARCH_DROP_OFF];

                $countSeatBoarding = 0;
                if (isset($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']))
                    $countSeatBoarding = count($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']);

                $countSeatDropOff = count($_POST['FormSeat'][Constant::SEARCH_DROP_OFF]['kursi']);
				$this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF]['jml_pnp'] = $countSeatDropOff;
                if ($countSeatBoarding != $countSeatDropOff) {
                    throw new CHttpException(500,'Jumlah kursi Kepulangan harus sama dengan Jumlah kursi Keberangkatan');
                }
            }
            if (isset($this->paramPost['FormBooking'])) {
                $this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF] = $_POST['FormBooking'][Constant::SEARCH_DROP_OFF];
            }
            Helper::getInstance()->setState(Constant::TEMP_POST, $this->paramPost);

            //redirect ke isi identitas
            return $this->redirect(Constant::baseUrl().'/front/fillForm');
        }

		if (isset(Yii::app()->session['post_seatmap']))
			$post = Yii::app()->session['post_seatmap'];
		if (!isset($post['route_id'], $post['armada_ke'], $post['doj'], $post['startdate'], $post['source_name'], $post['destination_name'], $post['source_id'], $post['destination_id'])){
			throw new CHttpException(500,'Invalid Parameter RouteID');
		}

		Yii::app()->session['post_seatmap'] = $post;
		$routeID = $post['route_id'];
        $data_transit = isset($post['data_transit']) && !empty($post['data_transit']) ? $post['data_transit'] : null;
        $search_type = isset($post['search_type']) ? $post['search_type'] : Constant::SEARCH_BOARDING;
        $model->doj = $post['doj'];
        $model->startdate = $post['startdate'];
        $model->enddate = isset($post['enddate']) && !empty($post['enddate']) ? $post['enddate'] : null;
		$model->route_id = $routeID;
		$model->trip_id = $post['trip_id'];
        $model->armada_ke = $post['armada_ke'];
        $model->source_name = $post['source_name'];
        $model->destination_name = $post['destination_name'];
        $model->source_id = $post['source_id'];
        $model->destination_id = $post['destination_id'];
        $model->search_type = $search_type;

        $listSeat = $model->seatmap();
		if (!isset($listSeat['data']['route'], $listSeat['data']['route']))
			throw new CHttpException(500,'Invalid Result Data :: ' . json_encode($listSeat),1);

        $data = isset($listSeat['data']['route']) ? $listSeat['data']['route'] : [];
		// Helper::getInstance()->dump($data);
        if ($model->search_type == Constant::SEARCH_BOARDING && isset($model->enddate))
				$button_text = "PILIH KURSI KEPULANGAN";
			else 
				$button_text = "LANJUTKAN";

        $data['btn_text'] = $button_text;

		$listSource = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$arrSource = isset($listSource['data']) ? $listSource['data'] : [];
		if (isset($arrSource[$model->source_id])) {
			$model->source_name = $arrSource[$model->source_id];
		}
		if (isset($arrTujuan[$model->destination_id])) {
			$model->destination_name = $arrTujuan[$model->destination_id];
		}
		// Helper::getInstance()->dump($model);
		$this->render('seatmap', [
            'model' => $model,
            'seatmap' => $listSeat['data']['seatmap'],
            'data' => $data,
			'listTujuan' => $arrSource,
			'arrTujuan' => $arrTujuan
        ]);
	}

	public function actionFillForm()
	{
		checkSessionPembelian();
		$model = new Booking('isiForm');

        $this->paramPost = Helper::getInstance()->getState(Constant::TEMP_POST);
        if (!isset($this->paramPost['FormBooking'][Constant::SEARCH_BOARDING]))
            throw new CHttpException(500,'Session is expired',1);

        $post = $this->paramPost['FormBooking'][Constant::SEARCH_BOARDING];
		if (!isset($post['startdate'], $post['boarding_name'], $post['destination_name'], $this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi'], $post['route_id']))
			throw new CHttpException(500,'Invalid Parameter',1);
		
		if (isset($_POST['Booking'], $_POST['BookingDetail'])) {
			$boardingData = $this->paramPost['FormSeat'][Constant::SEARCH_BOARDING];
			$boardingData = array_merge($boardingData, $_POST['BookingDetail']);
			$dropOffData = isset($this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF]) ? $this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF] : [];
			if (!empty($dropOffData)) {
				$dropOffData = array_merge($dropOffData, $_POST['BookingDetail']);
			}
			$this->paramPost['FormBooking'][Constant::SEARCH_BOARDING]['FormSeat'] = $boardingData;
			if (isset($this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF]) && !empty($this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF]))
				$this->paramPost['FormBooking'][Constant::SEARCH_DROP_OFF]['FormSeat'] = $dropOffData;

			$postBooking = $_POST['Booking'];
			//check terdaftar belum, kalau belum di-registrasikan
			$modelPassengerData = PassengerHelper::getInstance()->checkUser($postBooking);
			if (!isset($modelPassengerData['model'])) {
				throw new CHttpException(500,'Data Pelanggan tidak valid :: ' . $modelPassengerData['message'],1);
			}
			$modelPassenger = (object)$modelPassengerData['model'];
			$postBooking['passenger_id'] = $modelPassenger->id;
			$this->paramPost['PassengerData'] = $postBooking;

			//hit transaksi
			$saveTransaction = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/transaction',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'role' => Constant::BOOKING_PUBLIC,
						'kiosk' => true,
						'postBooking' => $this->paramPost
					]
				]
			]);
			
			if ($saveTransaction['success']) {
				Yii::app()->user->setFlash('success', 'Pembelian Tiket Berhasil Dibuat');
			} else {
				throw new CHttpException(500,$saveTransaction['message'],1);
			}

			return Yii::app()->controller->redirect(Constant::baseUrl().'/front/payTickets?id=' . (isset($saveTransaction['last_id_booking']) ? $saveTransaction['last_id_booking'] : 'all'));
		}

		// Helper::getInstance()->dump($post);
		$routeID = $post['route_id'];
		$data_transit = isset($post['data_transit']) && !empty($post['data_transit']) ? $post['data_transit'] : null;
        $search_type = isset($post['search_type']) ? $post['search_type'] : Constant::SEARCH_BOARDING;
        $model->doj = $post['startdate'];
        $model->startdate = $post['startdate'];
        $model->enddate = isset($post['enddate']) && !empty($post['enddate']) ? $post['enddate'] : null;
		$model->route_id = $routeID;
		$model->trip_id = $post['trip_id'];
        $model->armada_ke = $post['armada_ke'];
        $model->source_name = $post['boarding_name'];
        $model->destination_name = $post['destination_name'];
        $model->source_id = $post['source_id'];
        $model->destination_id = $post['destination_id'];
        $model->search_type = $search_type;

		//jumlah penumpang berangkat
		$post['jml_pnp_berangkat'] = count($this->paramPost['FormSeat'][Constant::SEARCH_BOARDING]['kursi']);
		$post['jml_pnp_pulang'] = isset($this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF]['kursi']) ? count($this->paramPost['FormSeat'][Constant::SEARCH_DROP_OFF]['kursi']) : 0;
		$total_bayar = $post['tarif'] * ($post['jml_pnp_berangkat'] + $post['jml_pnp_pulang']);
		$adminFee = (int)Setting::getValue("BIAYA_ADMIN_XENDIT", 3552);
		$post['admin_fee'] = $adminFee;
		$post['total_bayar'] = $total_bayar + $adminFee;

		if (isset(Yii::app()->user->nama, Yii::app()->user->username, Yii::app()->user->no_hp, Yii::app()->user->role) && in_array(Yii::app()->user->role, ['public'])) {
			$post['Booking']['nik'] = Yii::app()->user->nama;
			$post['Booking']['nama'] = Yii::app()->user->nama;
			$post['Booking']['email'] = Yii::app()->user->username;
			$post['Booking']['hp'] = Yii::app()->user->no_hp;
		}

		$listSource = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/listCitySource',
			'parameter' => [
				'method' => 'GET'
			]
		]);
		$arrTujuan = [];
		if (isset($model->source_id)) {
			$option = ApiHelper::getInstance()->callUrl([
				'url' => 'api/v1/kiosk/listCityDestination',
				'parameter' => [
					'method' => 'POST',
					'postfields' => [
						'titik_id' => $model->source_id
					]
				]
			]);

			if (isset($option['data']))
				$arrTujuan = $option['data'];
		}

		$arrSource = isset($listSource['data']) ? $listSource['data'] : [];
		if (isset($arrSource[$model->source_id])) {
			$model->source_name = $arrSource[$model->source_id];
		}
		if (isset($arrTujuan[$model->destination_id])) {
			$model->destination_name = $arrTujuan[$model->destination_id];
		}

		$this->render('fillForm', [
			'model' => $model,
			'post' => $post,
			'listTujuan' => $arrSource,
			'arrTujuan' => $arrTujuan
		]);
	}

	public function actionPayTickets()
	{
		if (!isset($_GET['id']))
			throw new CHttpException(500,'Invalid ID',1);

		$id = $_GET['id'];
		$getData = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/ticket',
			'parameter' => [
				'method' => 'POST',
				'postfields' => [
					'id' => $id
				]
			]
		]);
		if (!$getData['success'] || !isset($getData['model'], $getData['modelPassenger'], $getData['detailOrder'])) {
			throw new CHttpException(500,$getData['message'],1);
		}
		
		$model = (object)$getData['model'];
		$modelPassenger = (object)$getData['modelPassenger'];
		$detailOrder = $getData['detailOrder'];
		$items = [];
		foreach ($detailOrder as $d) {
			$items[] = [
				"name"=> "Seat ". $d['tipe_pembelian'] ." #" . $d['kursi'],
				"quantity"=> 1,
				"price"=> (int)$d['harga'],
				"category"=> "Ticket",
			];
		}
		//perhitungan admin fee
		$adminFee = (int)Setting::getValue("BIAYA_ADMIN_XENDIT", 3552);
		$markupManipulator = (float)$markupManipulator = Setting::getValue("PERSEN_QRIS", 0.7);
		$adminFeeReal = ($model->total_price * $markupManipulator) / 100;
		$payment_methods = ["BCA", "BNI", "BSI", "BRI", "MANDIRI", "PERMATA", "QRIS"];
		if ($adminFeeReal > $adminFee)
			$payment_methods = ["BCA", "BNI", "BSI", "BRI", "MANDIRI", "PERMATA"];

		$paramInvoice = [
			"external_id"=> 'invoice-'.strtotime(date('Y-m-d H:i:s')),
			"amount"=> $model->total_price,
			"payer_email"=> $modelPassenger->username,
			"description"=> "Invoice " . $model->unique_id,
			"invoice_duration"=>(int)Setting::getValue("PUBLIC_TIME_PAY_MINUTE", 600),
			"customer"=> [
							"given_names"=> $modelPassenger->name,
							"email"=> $modelPassenger->username,
							"mobile_number"=> $modelPassenger->no_hp,
							"addresses"=> []
						],
			"customer_notification_preference"=> [
				"invoice_created"=> [
					"whatsapp",
					"email"
				],
				"invoice_reminder"=> [
					"whatsapp",
					"email"
				],
				"invoice_paid"=> [
					"whatsapp",
					"email"
				]
			],
			"success_redirect_url"=> SERVER . '/front/successPayment?id=' . $this->encode($id),
			"failure_redirect_url"=> SERVER . '/front/failedPayment?id=' . $this->encode($id),
			"currency"=> "IDR",
			"items"=> $items,
			"fees" => [
				[
					"type" => "ADMIN",
					"value" => $adminFee
				]
			],
			"payment_methods"=>$payment_methods
		];

		$createInvoice = BookingHelper::getInstance()->createInvoice($paramInvoice);
		$log = [
			'booking_public_id' => $id,
			'type' => 'PAYMENT_REQUEST',
			'description' => json_encode($createInvoice),
			'created_date' => date('Y-m-d H:i:s')
		];
		$logPayment = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/logPayment',
			'parameter' => [
				'method' => 'POST',
				'postfields' => $log
			]
		]);
		if (!$logPayment['success']) {
			throw new CHttpException(500,'Link Pembayaran Kadaluwarsa atau pembayaran tidak valid',1);
		}

		// Helper::getInstance()->setState(Constant::ID_BOOKING_PUBLIC, $id);
		return $this->redirect($createInvoice['invoice_url']);
	}

	public function actionSuccessPayment()
    {
        if (!isset($_GET['id'])) {
            throw new CHttpException(500,'ID booking tidak valid',1);
        }
        $id = $_GET['id'];
        $id = $this->decode($id);

		$getData = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/confirmTicket',
			'parameter' => [
				'method' => 'POST',
				'postfields' => [
					'id' => $id
				]
			]
		]);
		if (!$getData['success'] || !isset($getData['modelBooking'])) {
			throw new CHttpException(500,$getData['message'],1);
		}
		$modelBooking = (object)$getData['modelBooking'];

        return $this->render("successPayment", ['modelBooking' => $modelBooking]);
    }

    public function actionFailedPayment()
    {
        return $this->render("failedPayment", []);
    }

    public function actionCetakTiket()
    {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            throw new CHttpException(500,'ID Tiket tidak valid',1);
        }
        $id = $_GET['id'];
		$getData = ApiHelper::getInstance()->callUrl([
			'url' => 'api/v1/kiosk/printTicket',
			'parameter' => [
				'method' => 'POST',
				'postfields' => [
					'id' => $id
				]
			]
		]);
		if (!$getData['success'] || !isset($getData['dataRaw'])) {
			throw new CHttpException(500,$getData['message'],1);
		}
        
        $dataRaw = (array)$getData['dataRaw'];
		if (!isset($dataRaw['data']))
			throw new CHttpException(401,'invalid DATA');

		$data = (array)$dataRaw['data'];
		require_once __DIR__ . '/../../vendor/autoload.php';
		$stylesheet = file_get_contents(__DIR__ . '/../../themes/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css');

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetTitle('e-Ticket Efisiensi');
		ob_start();
		ob_end_clean();
		$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);

		$i = 1;
		$count = count($data);
		foreach ($data as $data_) {
			$mpdf->WriteHTML($this->renderPartial('/front/template_e_ticket', [
				'data' => $data_
			], true));

			if ($i < $count){
				$mpdf->AddPage();
			}
			$i++;
		}
		
		$mpdf->shrink_tables_to_fit = 2;
		// $mpdf->Output('e-ticket.pdf', 'I');
        $mpdf->Output('e-ticket.pdf', 'D'); //download
		$res['success'] = 1;
		$res['message'] = '';
		return $res;
    }

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && ($_POST['ajax']==='register-form' || $_POST['ajax'] === 'register-checkpoint'))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}