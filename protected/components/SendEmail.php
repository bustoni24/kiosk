<?php

class SendEmail {

    public static $mainHost = HOST_SERVER;
    public static $mainMail = EMAIL_SERVER;
    public static $mainPass = PASS_EMAIL_SERVER;

    public function sendPenawaranBarang($data = [])
    {
        if (isset($data['supplier'], $data['modelPenawaran'])){
            $supplier = $data['supplier'];
            $modelPenawaran = $data['modelPenawaran'];

            $subject = 'Permintaan Harga Barang';
            $message = Yii::app()->controller->renderPartial('/site/sendEmailSupplier', array(
                'supplier' => $supplier,
                'modelPenawaran' => $modelPenawaran
            ), true);
            $from = "admin@efisiensi.id";
            $from_name = "INFO EFISIENSI";

            $this->sendMail([
                'message' => $message,
                'subject' => $subject,
                'from' => $from,
                'from_name' => $from_name,
                'email_to' => $supplier->email,
                'redirect' => false,
            ]);
        }
    }

    public function sendPembelianBarang($datas = [])
    {
        if (isset($datas) && !empty($datas)) {
            foreach ($datas as $id_supplier => $data_) {
                $supplier = Supplier::model()->findByPk($id_supplier);
                if (!isset($supplier))
                    return null;
                $pembelian = Pembelian::model()->findByAttributes(['id_pembelian' => $data_['id_pembelian']]);
                if (!isset($pembelian))
                    return null;
                $subject = 'Surat Order Pembelian';
                $message = Yii::app()->controller->renderPartial('/site/sendEmailPembelian', array(
                    'nomor'=>$data_['id_pembelian'],
                    'pemasok'=>$supplier->nama_supplier,
                    'alamat_pengiriman'=>$supplier->alamat,
                    'tanggal'=>$pembelian->created_date,
                    'orderBarang'=>$data_['barang']
                ), true);
                $from = "admin@efisiensi.id";
                $from_name = "INFO EFISIENSI";
    
                $this->sendMail([
                    'message' => $message,
                    'subject' => $subject,
                    'from' => $from,
                    'from_name' => $from_name,
                    'email_to' => $supplier->email,
                    'redirect' => false,
                ]);
            }
        }
    }

      private function sendMail($post = []){
        if (!isset($post['message']) || !isset($post['subject']) || !isset($post['from']) || !isset($post['from_name'])){

            Yii::app()->user->setFlash('error', 'Parameter tidak valid');
            Yii::app()->controller->redirect(Constant::baseUrl().'/register');
        }

            $mailer=dirname(__FILE__).'../../extensions/mailer/PHPMailerAutoload.php';
            require_once($mailer);

            $mail = new PHPMailer;        

        // Konfigurasi SMTP
            // $mail->SMTPDebug = 3; 
            $mail->isSMTP();
            $mail->Host = self::$mainHost;
            $mail->SMTPAuth = true;
            $mail->Username = self::$mainMail;
            $mail->Password = self::$mainPass;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

        //tambahkan variabel
            $namapengirim = $post['from_name'];
            $mailpengirim = $post['from'];
            $subjek       = $post['subject'];
            $pesan      = $post['message'];

            $mail->setFrom($mailpengirim, $namapengirim);
            $mail->addReplyTo($mailpengirim, $namapengirim);

            if (!isset($post['email_to']))
                $post['email_to'] = MAIL_ADMIN;
        // Menambahkan penerima
            if (isset($data['type'])){
                if ($data['type'] == 'member'){
                    $mail->addAddress($post['email_to']);
                } else if ($data['type'] == 'admin'){
                    $mail->addAddress(MAIL_ADMIN);
                }
            } else {
                $mail->addAddress($post['email_to']);
                $mail->addAddress(MAIL_ADMIN);
            }
        // Menambahkan beberapa penerima
        //$mail->addAddress('penerima2@contoh.com');
        //$mail->addAddress('penerima3@contoh.com');


        // Subjek email
            $mail->Subject = $subjek;

        // Mengatur format email ke HTML
            $mail->isHTML(true);

        // Konten/isi email
            $mail->Body = $pesan;

    // Kirim email
            if(!$mail->send()){
             echo "<script type='text/javascript'>window.alert('Pesan tidak dapat dikirim.')</script>";
             echo "<script type='text/javascript'>window.alert('Mailer Error: '" . json_encode($mail->ErrorInfo) . ")</script>";
             // echo "<script type='text/javascript'>window.location.href='home'</script>";
           }else{
            if (isset($post['redirect']) && $post['redirect'])
               echo "<script type='text/javascript'>window.alert('Pesan Anda telah dikirim, terimakasih telah menghubungi kami'); window.location.assign('home')</script>";
           }
        }

        // Function to get the client IP address
         public function get_client_ip() {
            $ipaddress = '';
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if(isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if(isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        public function sendEmailTes($post = []){

            $mailer=dirname(__FILE__).'../../extensions/mailer/PHPMailerAutoload.php';
            require_once($mailer);

            $mail = new PHPMailer;

// Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = '';
            $mail->SMTPAuth = true;
            $mail->Username = '';
            $mail->Password = '';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;


//tambahkan variabel
            $namapengirim = $post['from_name'];
            $mailpengirim = $post['from'];
            $subjek       = $post['subject'];
            $pesan      = $post['message'];

            $mail->setFrom($mailpengirim, $namapengirim);
            $mail->addReplyTo($mailpengirim, $namapengirim);

// Menambahkan penerima
            // $mail->addAddress($post['email_to']);
            $mail->addAddress("bustoni.nugroho@gmail.com");

// Subjek email
            $mail->Subject = $subjek;

// Mengatur format email ke HTML
            $mail->isHTML(true);

// Konten/isi email
            $mail->Body = $pesan;

// Kirim email
            if(!$mail->send()){
               exit(json_encode($mail->ErrorInfo));
           }else{
               echo "<script type='text/javascript'>window.alert('Pesan Anda telah dikirim, terimakasih telah menghubungi kami'); window.location.assign('home')</script>";
           }
       }

    private static $instance;

    private function __construct()
    {
        // Hide the constructor
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}