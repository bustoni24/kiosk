<?php

class VFormatter extends CWidget {

    /**
     * format number to rupiah
     * @param type $number
     * @return type
     */

    public static function getStatusDeposit(){
        $array = array('0'=>'Belum Dikirim', '1'=>'Sudah Dikirim', '2'=>'Telah Dibatalkan');
        return $array;
    }

    public static function getJenisDeposit(){
        $array = array('1'=>'Pembukaan', '2'=>'Top Up', '3'=>'Penutupan');
        return $array;
    }


    public static function getPlainText($text){
        $result = "";
        $allow = true;
        for($i = 0; $i < strlen($text); $i++){
            if($text[$i] == '<') $allow = false;
            else if($text[$i] == '>') $allow = true;
            else if($allow){
                $result .= $text[$i];
            }
        }
        return $result;

    }

    public static function getTroli($id){
        $modelCart = Cart::model()->findAll('cart_detail_id = '. $id);
        $troli = "";
        foreach ($modelCart as $key) {
            if(isset($key->product->product_code) && isset($key->qty)){
                if($troli == ""){
                    $troli .= $key->product->product_code . '-' . $key->qty;
                }else{
                    $troli .= '&' . $key->product->product_code . '-' . $key->qty;
                }    
            }
            
        }
        return base64_encode($troli);
    }

    public static function filterProvince($provinceText){
        $konversi = ['nanggroe aceh darussalam'=> 'aceh',
                     'sumatera bar'=> 'sumatera barat',
                     'daerah khusus ibukota jakarta'=> 'dki jakarta',
                     'nusa Tenggara bar'=> 'nusa tenggara barat',
                     'nusa Tenggara tim'=> 'nusa tenggara timur',
                     'kalimantan bar'=> 'kalimantan barat',
                     'kalimantan tim'=> 'kalimantan timur',
                     'kalimantan sel'=> 'kalimantan selatan',
                     'sulawesi bar'=> 'sumatera barat',
                     'papua bar'=> 'papua barat',
                ];
        if(isset($konversi[$provinceText])){
            return $konversi[$provinceText];
        }
        return $provinceText;
    }
    
    public static function filterCity($cityText){
        $konversi = [
        "aceh singkil regency" => "aceh singkil",
        "south aceh regency" => "aceh selatan",
        "pidie" => "pidie jaya",
        "south nias regency" => "nias selatan",
        "labuhanbatu utara" => "labuhan batu utara",
        "medan" => "kota medan",
        "kota padang sidempuan" => "kota padangsidimpuan",
        "indragiri hulu regency" => "indragiri hulu",
        "pelalawan regency" => "pelalawan",
        "siak" => "s i a k",
        "kota dumai" => "kota d u m a i",
        "tanjung jabung t" => "tanjung jabung timur",
        "ogan komering ilir regency" => "ogan komering ilir",
        "musi rawas utara" => "musi rawas",
        "banyu asin regency" => "banyu asin",
        "north bengkulu regency" => "bengkulu utara",
        "south lampung regency" => "lampung selatan",
        "tulangbawang barat" => "tulang bawang barat",
        "tulangbawang" => "tulang bawang",
        "pesisir bar." => "pesisir barat",
        "bintan regency" => "bintan",
        "natuna regency" => "natuna",
        "kota batam" => "kota b a t a m",
        "tanjung pinang" => "kota tanjung pinang",
        "kota jkt utara" => "kota jakarta utara",
        "kota sukabumi" => "sukabumi",
        "kota bks" => "kota bekasi",
        "tasikmalaya" => "kota tasikmalaya",
        "kota pekalongan" => "pekalongan",
        "kota blitar" => "blitar",
        "kota pasuruan" => "pasuruan",
        "lamongan regency" => "lamongan",
        "sumenep regency" => "sumenep",
        "kediri" => "kota kediri",
        "kota sby" => "kota surabaya",
        "kota serang" => "serang",
        "tangerang" => "kota tangerang",
        "tangerang selatan" => "kota tangerang selatan",
        "gianyar" => "gianyar",
        "karangasem" => "karang asem",
        "bima" => "kota bima",
        "kapuas hulu regency" => "kapuas hulu",
        "melawi regency" => "melawi",
        "north kayong regency" => "kayong utara",
        "west kotawaringin regency" => "kotawaringin barat",
        "south barito regency" => "barito selatan",
        "sukamara regency" => "sukamara",
        "seruyan regency" => "seruyan",
        "katingan regency" => "katingan",
        "baru city regency" => "kota baru",
        "kab. barito kuala" => "barito kuala",
        "berau regency" => "berau",
        "mahakam ulu" => "mahakam hulu",
        "west kutai regency" => "kutai barat",
        "malinau regency" => "malinau",
        "minahasa utara" => "minahasa",
        "kepulauan sangihe regency" => "kepulauan sangihe",
        "kepulauan talaud regency" => "kepulauan talaud",
        "banggai laut" => "banggai kepulauan",
        "morowali utara" => "morowali",
        "selayar" => "kepulauan selayar",
        "pangkajene dan kepulauan regency" => "pangkajene dan kepulauan",
        "east luwu regency" => "luwu timur",
        "kota pare-pare" => "kota parepare",
        "parepare" => "kota parepare",
        "konawe kepulauan" => "konawe",
        "kolaka tim." => "kolaka timur",
        "konawe regency" => "konawe",
        "north konawe regency" => "konawe utara",
        "kolaka regency" => "kolaka",
        "kota bau-bau" => "kota baubau",
        "kota gorontalo" => "gorontalo",
        "kepulauan aru regency" => "kepulauan aru",
        "east seram bagian regency" => "seram bagian timur",
        "kepulauan sula regency" => "kepulauan sula",
        "south halmahera regency" => "halmahera selatan",
        "north halmahera regency" => "halmahera utara",
        "kaimana regency" => "kaimana",
        "teluk wondama regency" => "teluk wondama",
        "teluk bintuni regency" => "teluk bintuni",
        "manokwari regency" => "manokwari",
        "kota sorong" => "sorong",
        "raja ampat regency" => "raja ampat",
        "tambrauw regency" => "tambrauw",
        "merauke regency" => "merauke",
        "jayawijaya regency" => "jayawijaya",
        "nabire regency" => "nabire",
        "kepulauan yapen regency" => "kepulauan yapen",
        "paniai regency" => "paniai",
        "puncak jaya regency" => "puncak jaya",
        "mimika regency" => "mimika",
        "boven digoel regency" => "boven digoel",
        "mappi regency" => "mappi",
        "asmat regency" => "asmat",
        "yahukimo regency" => "yahukimo",
        "pegunungan bintang regency" => "pegunungan bintang",
        "tolikara regency" => "tolikara",
        "sarmi regency" => "sarmi",
        "keerom regency" => "keerom",
        "waropen regency" => "waropen",
        "mamberamo raya regency" => "mamberamo raya",
        "nduga regency" => "nduga",
        "central mamberamo regency" => "mamberamo tengah",
        "yalimo regency" => "yalimo",
        "puncak regency" => "puncak",
        "dogiyai regency" => "dogiyai",
        "intan jaya regency" => "intan jaya",
        "sukabumi" => "kab. sukabumi",
        "bandung" => "kab. bandung",
        "bandung barat" => "kab. bandung barat",
        "cirebon" => "kab. cirebon",
        "bekasi" => "kab. bekasi",
                ];
        if(isset($konversi[$cityText])){
            return $konversi[$cityText];
        }
        return $cityText;
    }

    public static function filterDistrict($districtText){
        $konversi = [
                     "ps minggu"=> "pasar minggu",
                     "mampang prpt"=> "mampang prapatan",
                     "cemp putih"=>"cempaka putih",
                     "kb jeruk"=>"kebon jeruk",
                     "tj priok"=>"tanjung priok",
                     "klp gading"=>"kelapa gading",
                     "gn anyar"=>"gunung anyar",
                     "ungaran bar"=>"ungaran barat",
                     "ungaran tim"=>"ungaran timur",
                     "gn pati"=>"gunung pati",
                    "teupah sel" => "teupah selatan",
                    "simeulue tim" => "simeulue timur",
                    "teupah bar" => "teupah barat",
                    "tlk dalam" => "teluk dalam",
                    "simeulue bar" => "simeulue barat",
                    "banyak island" => "pulau banyak",
                    "west banyak island" => "pulau banyak barat",
                    "gn meriah" => "gunung meriah",
                    "suro makmur" => "suro",
                    "trumon tim" => "trumon timur",
                    "bakongan tim" => "bakongan timur",
                    "kluet tim" => "kluet timur",
                    "central kluet" => "kluet tengah",
                    "labuhan h" => "labuhan haji",
                    "labuhan h tim" => "labuhan haji timur",
                    "labuhan h bar" => "labuhan haji barat",
                    "lawe sigala-gala" => "lawe sigala-gala",
                    "peureulak tim" => "peureulak timur",
                    "peureulak bar" => "peureulak barat",    
                    "woyla bar" => "woyla barat",
                    "woyla tim" => "woyla timur",
                    "mutiara tim" => "mutiara timur",
                    "kembang tj" => "kembang tanjong",
                    "peusangan sel" => "peusangan selatan",
                    "baktiya bar" => "baktiya barat",
                    "seunagan tim" => "seunagan timur",
                    "langsa tim" => "langsa timur",
                    "langsa bar" => "langsa barat",
                    "langsa kota" => "langsa baro",
                    "panyabungan sel" => "panyabungan selatan",
                    "panyabungan bar" => "panyabungan barat",
                    "angkola tim" => "angkola timur",
                    "angkola sel" => "angkola selatan",
                    "angkola bar" => "angkola barat",
                    "pinang sori" => "pinang sori",
                    "sorkam bar" => "sorkam barat",
                    "lagu boti" => "laguboti",
                    "bilah bar" => "bilah barat",
                    "rantau sel" => "rantau selatan",
                    "sei kepayang bar" => "sei kepayang barat",
                    "sei kepayang tim" => "sei kepayang timur",
                    "tj balai sel" => "tanjung balai selatan",
                    "tj balai" => "tanjung balai",
                    "tanjungbalai" => "tanjung balai",
                    "tanjungbalai utara" => "tanjung balai utara",
                    "kisaran bar" => "kisaran barat",
                    "kisaran tim" => "kisaran timur",
                    "siantar bar" => "siantar barat",
                    "siantar tim" => "siantar timur",
                    "siantar sel" => "siantar selatan",
                    "dolok batunanggar" => "dolok batu nanggar",
                    "gn malela" => "gunung malela",
                    "gn maligas" => "gunung maligas",
                    "gn sitember" => "gunung sitember",
                    "sinembah tj muda hulu" => "sinembah tanjung muda hulu",
                    "sinembah tj muda hilir" => "sinembah tanjung muda hilir",
                    "tj morawa" => "tanjung morawa",
                    "serapit" => "sirapit",
                    "binjai tim" => "binjai timur",
                    "binjai sel" => "binjai selatan",
                    "binjai bar" => "binjai barat",
                    "binjai" => "binjai kota",
                    "tj pura" => "tanjung pura",
                    "brandan bar" => "brandan barat",
                    "pulau batu island" => "pulau-pulau batu",
                    "lolowau" => "lolowa'u",
                    "tebing tinggi" => "tebingtinggi",
                    "tj beringin" => "tanjung beringin",
                    "tlk mengkudu" => "teluk mengkudu",
                    "tj tiram" => "tanjung tiram",
                    "barumun sel" => "barumun selatan",
                    "kp rakyat" => "kampung rakyat",
                    "lahewa tim" => "lahewa timur",
                    "mandrehe bar" => "mandrehe barat",
                    "sibolga sel" => "sibolga selatan",
                    "datuk bandar tim" => "datuk bandar timur",
                    "tanjungbalai utara" => "tanjung balai utara",
                    "tlk nibung" => "teluk nibung",
                    "medan bar" => "medan barat",
                    "medan tim" => "medan timur",
                    "medan kota belawan" => "medan belawan",
                    "padangsidimpuan sel" => "padangsidimpuan selatan",
                    "gunungsitoli sel" => "gunungsitoli selatan",
                    "gn sitoli" => "gunung sitoli",
                    "pagai sel" => "pagai selatan",
                    "siberut sel" => "siberut selatan",
                    "siberut bar" => "siberut barat",
                    "tigo lurah bajanjang" => "tigo lurah",
                    "gn talang" => "gunung talang",
                    "ix koto sungai lasi" => "ix koto sungai lasi",
                    "tj gadang" => "tanjung gadang",
                    "iv nagari" => "iv nagari",
                    "tj emas" => "tanjung emas",
                    "tj baru" => "tanjung baru",
                    "v koto kp dalam" => "v koto kp dalam",
                    "v koto tim" => "v koto timur",
                    "tj mutiara" => "tanjung mutiara",
                    "tj raya" => "tanjung raya",
                    "payakumbuh bar" => "payakumbuh",
                    "mapat tunggul sel" => "mapat tunggul selatan",
                    "rao sel" => "rao selatan",
                    "gn tuleh" => "gunung tuleh",
                    "bungus tlk kabung" => "bungus teluk kabung",
                    "padang sel" => "padang selatan",
                    "padang tim" => "padang timur",
                    "padang bar" => "padang barat",
                    "tj harapan" => "tanjung harapan",
                    "padang panjang bar" => "padang panjang barat",
                    "payakumbuh sel" => "payakumbuh selatan",
                    "payakumbuh tim" => "payakumbuh timur",
                    "pariaman sel" => "pariaman selatan",
                    "pariaman tim" => "pariaman timur",
                    "gn toar" => "gunung toar",
                    "rengat bar" => "rengat barat",
                    "tanah merah" => "tanah merah",
                    "tlk belengkong" => "teluk belengkong",
                    "gn sahilan" => "gunung sahilan",
                    "kampar tim" => "kampar timur",
                    "tanah putih tj melawan" => "tanah putih tanjung melawan",
                    "tebing tinggi bar" => "tebing tinggi barat",
                    "tebing tinggi tim" => "tebing tinggi timur",
                    "rangsang bar" => "rangsang barat",
                    "pulaumerbau" => "merbau",
                    "tasik putri puyu" => "putri puyu",
                    "dumai bar" => "dumai barat",
                    "dumai tim" => "dumai timur",
                    "gn raya" => "gunung raya",
                    "air hangat tim" => "air hangat timur",
                    "air hangat bar" => "air hangat barat",
                    "gn kerinci" => "gunung kerinci",
                    "gn tujuh" => "gunung tujuh",
                    "kayu aro bar" => "kayu aro barat",
                    "pamenang bar" => "pamenang barat",
                    "bangko bar" => "bangko barat",    
                    "tabir sel" => "tabir selatan",
                    "tabir tim" => "tabir timur",
                    "tabir bar" => "tabir barat",
                    "bahar sel" => "bahar selatan",
                    "bahar utara" => "bahar utara",
                    "muara sabak bar" => "muara sabak barat",
                    "sabak bar" => "muara sabak barat",
                    "muara sabak tim" => "muara sabak timur",
                    "ps muara bungo" => "pasar muara bungo",
                    "bathin iii ulu" => "bathin iii",
                    "muko-muko bathin" => "muko-muko bathin vii",
                    "jambi sel" => "jambi selatan",
                    "ps jambi" => "pasar jambi",
                    "danau tlk" => "danau teluk",
                    "jambi tim" => "jambi timur",
                    "tanah kp" => "tanah kampung",
                    "batu raja tim" => "batu raja timur",
                    "batu raja bar" => "batu raja barat",
                    "pedamaran tim" => "pedamaran timur",
                    "tj lubuk" => "tanjung lubuk",
                    "tlk gelam" => "teluk gelam",
                    "tj agung" => "tanjung agung",
                    "gn megang" => "gunung megang",
                    "tj sakti pumi" => "tanjung sakti pumi",
                    "tj sakti pumu" => "tanjung sakti pumu",
                    "tj tebat" => "tanjung tebat",
                    "pagar gn" => "pagar gunung",
                    "kikim bar" => "kikim barat",
                    "kikim tim" => "kikim timur",
                    "kikim sel" => "kikim selatan",
                    "merapi bar" => "merapi barat",
                    "merapi tim" => "merapi timur",
                    "merapi sel" => "merapi selatan",
                    "talang klp" => "talang kelapa",
                    "tj lago" => "tanjung lago",
                    "warkuk ranau sel" => "warkuk ranau selatan",
                    "buay pematang ribu ranau tenga" => "buay pematang ribu ranau tengah",
                    "buay madang tim" => "buay madang timur",
                    "semendawai tim" => "semendawai timur",
                    "semendawai bar" => "semendawai barat",
                    "tj batu" => "tanjung batu",
                    "tj raja" => "tanjung raja",
                    "pemulutan sel" => "pemulutan selatan",
                    "pemulutan bar" => "pemulutan barat",
                    "indralaya sel" => "indralaya selatan",
                    "pasma air keruh" => "pasemah air keruh",
                    "ilir bar ii" => "ilir barat ii",
                    "ilir bar i" => "ilir barat i",
                    "ilir tim i" => "ilir timur i",
                    "ilir tim ii" => "ilir timur ii",
                    "prabumulih tim" => "prabumulih timur",
                    "prabumulih sel" => "prabumulih selatan",
                    "prabumulih bar" => "prabumulih barat",    
                    "pagar alam sel" => "pagar alam selatan",
                    "lubuk linggau bar i" => "lubuk linggau barat i",
                    "lubuk linggau bar ii" => "lubuk linggau barat ii",
                    "lubuk linggau sel i" => "lubuk linggau selatan i",
                    "lubuk linggau sel ii" => "lubuk linggau selatan ii",
                    "lubuk linggau tim i" => "lubuk linggau timur i",
                    "lubuk linggau tim ii" => "lubuk linggau timur ii",
                    "lubuk linggau utara ii" => "lubuk linggau utara ii",
                    "ps manna" => "pasar manna",
                    "curup sel" => "curup selatan",
                    "curup tim" => "curup timur", 
                    "tlk segara" => "teluk segara",
                    "air padang" => "air padang",
                    "kaur sel" => "kaur selatan",
                    "tj kemuning" => "tanjung kemuning",    
                    "seluma sel" => "seluma selatan",
                    "seluma bar" => "seluma barat",
                    "seluma tim" => "seluma timur",
                    "pd suguh" => "pondok suguh",
                    "lebong sel" => "lebong selatan",
                    "pd klp" => "pondok kelapa",
                    "pd kubang" => "pondok kubang",
                    "bang h" => "bang haji",
                    "kp melayu" => "kampung melayu",
                    "gading cemp" => "gading cempaka",
                    "lombok seminung" => "lumbok seminung",    
                    "kota agung tim" => "kota agung timur",
                    "kota agung bar" => "kota agung barat",
                    "gn alip" => "gunung alip",
                    "kelumbayan bar" => "kelumbayan barat",
                    "tj bintang" => "tanjung bintang",
                    "tj sari" => "tanjung sari",
                    "marga sekapung" => "marga sekampung",
                    "gn pelindung" => "gunung pelindung",
                    "gn sugih" => "gunung sugih",
                    "abung bar" => "abung barat",
                    "kotabumi sel" => "kotabumi selatan",
                    "abung sel" => "abung selatan",
                    "abung tim" => "abung timur",
                    "sungkai sel" => "sungkai selatan",
                    "sungkai bar" => "sungkai barat",
                    "gn labuhan" => "gunung labuhan",
                    "rawajitu sel" => "rawajitu selatan",
                    "rawajitu tim" => "rawajitu timur",
                    "rw pitu" => "rawa pitu",
                    "menggala tim" => "menggala timur",
                    "pagelaran" => "pagelaran utara",
                    "mesuji tim" => "mesuji timur",
                    "gn terang" => "gunung terang",
                    "gn agung" => "gunung agung",
                    "krui sel" => "krui selatan",
                    "pesisir sel" => "pesisir selatan",
                    "bengkunat belimbing" => "bengkunat",
                    "tlk betung bar" => "teluk betung barat",
                    "tlk betung sel" => "teluk betung selatan",
                    "tj karang tim" => "tanjung karang timur",
                    "tlk betung utara" => "teluk betung utara",
                    "tj karang pusat" => "tanjung karang pusat",
                    "tj karang bar" => "tanjung karang barat",
                    "tj senang" => "tanjung senang",
                    "metro sel" => "metro selatan",
                    "metro bar" => "metro barat",
                    "metro tim" => "metro timur",
                    "mendo bar" => "mendo barat",
                    "tj pandan" => "tanjung pandan",
                    "klp kampit" => "kelapa kampit",
                    "kundur bar" => "kundur barat",
                    "tlk bintan" => "teluk bintan",
                    "tlk sebong" => "teluk sebong",
                    "bintan tim" => "bintan timur",
                    "gn kijang" => "gunung kijang",
                    "bunguran bar" => "bunguran barat",
                    "laut island" => "pulau laut",
                    "bunguran tim" => "bunguran timur",
                    "bunguran tim laut" => "bunguran timur laut",
                    "bunguran sel" => "bunguran selatan",
                    "serasan tim" => "serasan timur",
                    "singkep tim" => "singkep timur",
                    "singkep bar" => "singkep barat",
                    "singkep sel" => "singkep selatan",
                    "jemaja tim" => "jemaja timur",
                    "siantan tim" => "siantan timur",
                    "siantan sel" => "siantan selatan",
                    "pal matak" => "palmatak",
                    "tanjungpinang bar" => "tanjungpinang barat",
                    "ps minggu" => "pasar minggu",
                    "kby lama" => "kebayoran lama",
                    "kby baru" => "kebayoran baru",
                    "mampang prpt" => "mampang prapatan",
                    "setiabudi" => "setia budi",
                    "ps rebo" => "pasar rebo",
                    "kramatjati" => "kramat jati",
                    "cemp putih" => "cempaka putih",
                    "kb jeruk" => "kebon jeruk",
                    "grogol petamburan" => "grogol petamburan",
                    "tamansari" => "taman sari",
                    // "kalideres" => "kali deres",
                    "tj priok" => "tanjung priok",
                    "klp gading" => "kelapa gading",
                    "klp nunggal" => "kelapa nunggal",
                    "gn putri" => "gunung putri",
                    "gn sindur" => "gunung sindur",
                    "cikembar" => "cimanggu",
                    "pelabuhan ratu" => "palabuhanratu",
                    "wr kiara" => "warung kiara",
                    "sumedang sel" => "sumedang selatan",
                    "pagaden bar" => "pagaden barat",
                    "pd salam" => "pondok salam",
                    "telukjambe bar" => "telukjambe barat",
                    "karawang tim" => "karawang timur",
                    "karawang bar" => "karawang barat",
                    "cikarang sel" => "cikarang selatan",
                    "cikarang tim" => "cikarang timur",
                    "cikarang bar" => "cikarang barat",
                    "tambun sel" => "tambun selatan",
                    "bogor sel" => "bogor selatan",
                    "bogor tim" => "bogor timur",
                    "bogor bar" => "bogor barat",
                    "gn puyuh" => "gunung puyuh",
                    "bekasi tim" => "bekasi timur",
                    "bekasi sel" => "bekasi selatan",
                    "bekasi bar" => "bekasi barat",
                    "pancoran mas" => "pancoran mas",
                    "sukmajaya" => "sukma jaya",
                    "cimahi sel" => "cimahi selatan",
                    "kp laut" => "kampung laut",
                    "purwokerto sel" => "purwokerto selatan",
                    "purwokerto bar" => "purwokerto barat",
                    "purwokerto tim" => "purwokerto timur",
                    "klaten sel" => "klaten selatan",
                    "blora kota" => "kota blora",
                    "gn wungkal" => "gunung wungkal",
                    "ungaran bar" => "ungaran barat",
                    "ungaran tim" => "ungaran timur",
                    "kaliwungu sel" => "kaliwungu selatan",
                    "warungasem" => "warung asem",
                    "pekalongan sel" => "pekalongan selatan",
                    "pekalongan bar" => "pekalongan barat",
                    "magelang sel" => "magelang selatan",
                    "ps kliwon" => "pasar kliwon",
                    "gn pati" => "gunung pati",
                    "gajahmungkur" => "gajah mungkur",
                    "semarang sel" => "semarang selatan",
                    "semarang tim" => "semarang timur",
                    "semarang bar" => "semarang barat",
                    "pekalongan tim" => "pekalongan timur",
                    "tegal sel" => "tegal selatan",
                    "tegal tim" => "tegal timur",
                    "tegal bar" => "tegal barat",
                    "tanggung gn" => "tanggung gunung",
                    "pagerwojo" => "pager wojo",
                    "kotasumenep" => "kota sumenep",
                    "gn anyar" => "gunung anyar",
                    "gn kencana" => "gunung kencana",
                    "klp dua" => "kelapa dua",
                    "gn kaler" => "gunung kaler",
                    "mekarbaru" => "mekar baru",
                    "sepatan tim" => "sepatan timur",
                    "gunungsari" => "gunung sari",
                    "puloampel" => "pulo ampel",
                    "ciputat tim" => "ciputat timur",
                    "pd aren" => "pondok aren",
                    "selemadeg tim" => "selemadeg timur",
                    "selemadeg bar" => "selemadeg barat",
                    "kuta sel" => "kuta selatan",
                    "denpasar sel" => "denpasar selatan",
                    "denpasar tim" => "denpasar timur",
                    "denpasar bar" => "denpasar barat",
                    "sekotong tengah" => "sekotong",
                    "gn sari" => "gunung sari",
                    "praya bar" => "praya barat",
                    "praya bar daya" => "praya barat daya",
                    "praya tim" => "praya timur",
                    "sakra bar" => "sakra barat",
                    "sakra tim" => "sakra timur",
                    "lunyuk rea" => "lunyuk",
                    "alas bar" => "alas barat",
                    "rasanae bar" => "rasanae barat",
                    "laboya bar" => "laboya barat",
                    "semau sel" => "semau selatan",
                    "kupang bar" => "kupang barat",
                    "amarasi bar" => "amarasi barat",
                    "amarasi sel" => "amarasi selatan",
                    "amarasi tim" => "amarasi timur",
                    "kupang tim" => "kupang timur",
                    "amabi oefeto tim" => "amabi oefeto timur",
                    "fatuleu bar" => "fatuleu barat",
                    "amfoang sel" => "amfoang selatan",
                    "amfoang bar daya" => "amfoang barat daya",
                    "amfoang tim" => "amfoang timur",
                    "mollo sel" => "mollo selatan",
                    "mollo bar" => "mollo barat",
                    "amanuban bar" => "amanuban barat",
                    "amanuban sel" => "amanuban selatan",
                    "amanuban tim" => "amanuban timur",
                    "amanatun sel" => "amanatun selatan",
                    "miomaffo bar" => "miomaffo barat",
                    "miomaffo tim" => "miomaffo timur",
                    "bikomi sel" => "bikomi selatan",
                    "noemuti tim" => "noemuti timur",
                    "insana bar" => "insana barat",
                    "insana utara" => "insana tengah",
                    "biboki sel" => "biboki selatan",
                    "tasifeto bar" => "tasifeto barat",
                    "atambua bar" => "atambua barat",
                    "atambua sel" => "atambua selatan",
                    "tasifeto tim" => "tasifeto timur",
                    "lamaknen sel" => "lamaknen selatan",
                    "pantar bar" => "pantar barat",
                    "pantar tim" => "pantar timur",
                    "kec pantar bar laut" => "pantar barat laut",
                    "alor bar laut" => "alor barat laut",
                    "alor bar daya" => "alor barat daya",
                    "alor sel" => "alor selatan",
                    "alor tim" => "alor timur",
                    "alor tim laut" => "alor timur laut",
                    "tlk mutiara" => "teluk mutiara",
                    "ile ape" => "ile ape timur",
                    "tj bunga" => "tanjung bunga",
                    "solor bar" => "solor barat",
                    "solor sel" => "solor selatan",
                    "solor tim" => "solor timur",
                    "adonara bar" => "adonara barat",
                    "wotan ulu mado" => "wotan ulu mado",
                    "adonara tim" => "adonara timur",
                    "alok bar" => "alok barat",
                    "alok tim" => "alok timur",
                    "ende sel" => "ende selatan",
                    "ende tim" => "ende timur",
                    "ndona tim" => "ndona timur",
                    "lio tim" => "lio timur",
                    "golewa sel" => "golewa selatan",
                    "golewa bar" => "golewa barat",
                    "riung bar" => "riung barat",
                    "satar mese bar" => "satar mese barat",
                    "rote bar daya" => "rote barat daya",
                    "rote bar laut" => "rote barat laut",
                    "rote sel" => "rote selatan",
                    "rote tim" => "rote timur",
                    "rote bar" => "rote barat",
                    "lembor sel" => "lembor selatan",
                    "katikutana sel" => "katikutana selatan",
                    "umbu ratu nggay bar" => "umbu ratu nggay barat",
                    "wewewa sel" => "wewewa selatan",
                    "wewewa bar" => "wewewa barat",
                    "wewewa tim" => "wewewa timur",
                    "aesesa sel" => "aesesa selatan",
                    "elar sel" => "elar selatan",
                    "sabu bar" => "sabu barat",
                    "sabu tim" => "sabu timur",
                    "malaka bar" => "malaka barat",
                    "malaka tim" => "malaka timur",
                    "kobalima tim" => "kobalima timur",
                    "klp lima" => "kelapa lima",
                    "selakau tim" => "selakau timur",
                    "kecamtan sambas" => "sambas",
                    "jawai sel" => "jawai selatan",
                    "tlk keramat" => "teluk keramat",
                    "mempawah tim" => "mempawah timur",
                    "matan hilir sel" => "matan hilir selatan",
                    "putussibau sel" => "putussibau selatan",
                    "boyan tj" => "boyan tanjung",
                    "north putussibau" => "putussibau utara",
                    "west tanah pinoh" => "tanah pinoh barat",
                    "pinoh sel" => "pinoh selatan",
                    "pulau maya karimata" => "pulau maya",
                    "maya karimata island" => "kepulauan karimata",
                    "tlk batang" => "teluk batang",
                    "pontianak sel" => "pontianak selatan",
                    "pontianak tim" => "pontianak timur",
                    "pontianak bar" => "pontianak barat",
                    "singkawang sel" => "singkawang selatan",
                    "singkawang tim" => "singkawang timur",
                    "singkawang bar" => "singkawang barat",
                    "arut sel" => "arut selatan",
                    "tlk sampit" => "teluk sampit",
                    "kapuas tim" => "kapuas timur",
                    "kapuas bar" => "kapuas barat",
                    "dusun sel" => "dusun selatan",
                    "gn bintang awai" => "gunung bintang awai",
                    "montallat" => "montalat",
                    "gn timang" => "gunung timang",
                    "gn purei" => "gunung purei",
                    "teweh tim" => "teweh timur",
                    "teweh sel" => "teweh selatan",
                    "lahei" => "lahei barat",
                    "bulik tim" => "bulik timur",
                    "rungan bar" => "rungan barat",
                    "dusun tim" => "dusun timur",
                    "dusun sel" => "dusun selatan",
                    "tanah siang sel" => "tanah siang selatan",
                    "sembilan island" => "pulau sembilan",
                    "pulau laut bar" => "pulau laut barat",
                    "pulau laut sel" => "pulau laut selatan",
                    "pulau island" => "pulau laut kepulauan",
                    "pulau laut tim" => "pulau laut timur",
                    "kelumpang sel" => "kelumpang selatan",
                    "kelumpang bar" => "kelumpang barat",
                    "pamukan sel" => "pamukan selatan",
                    "pamukan bar" => "pamukan barat",
                    "aluh-aluh" => "aluh - aluh",
                    "martapura tim" => "martapura timur",
                    "martapura bar" => "martapura barat",
                    "mekarsari" => "mekar sari",
                    "anjir ps" => "anjir pasar",
                    "tapin sel" => "tapin selatan",
                    "candi laras sel" => "candi laras selatan",
                    "daha sel" => "daha selatan",
                    "daha bar" => "daha barat",
                    "batang alai sel" => "batang alai selatan",
                    "batang alai tim" => "batang alai timur",
                    "labuan amas sel" => "labuan amas selatan",
                    "paringin sel" => "paringin selatan",
                    "banjarmasin sel" => "banjarmasin selatan",
                    "banjarmasin tim" => "banjarmasin timur",
                    "banjarmasin bar" => "banjarmasin barat",
                    "banjar baru sel" => "banjar baru selatan",
                    "tlk pandan" => "teluk pandan",
                    "sangatta sel" => "sangatta selatan",
                    "tj redeb" => "tanjung redeb",
                    "gn tabur" => "gunung tabur",
                    "tlk bayur" => "teluk bayur",
                    "balikpapan sel" => "balikpapan selatan",
                    "balikpapan tim" => "balikpapan timur",
                    "balikpapan bar" => "balikpapan barat",
                    "bontang sel" => "bontang selatan",
                    "bontang bar" => "bontang barat",
                    "kayan sel" => "kayan selatan",
                    "malinau sel" => "malinau selatan",
                    "malinau bar" => "malinau barat",
                    "tj palas bar" => "tanjung palas barat",
                    "tj palas" => "tanjung palas",
                    "tj selor" => "tanjung selor",
                    "tj palas tim" => "tanjung palas timur",
                    "tj palas tengah" => "tanjung palas tengah",
                    "tj palas utara" => "tanjung palas utara",
                    "krayan sel" => "krayan selatan",
                    "nunukan sel" => "nunukan selatan",
                    "sebatik bar" => "sebatik barat",
                    "sebatik tim" => "sebatik timur",
                    "tarakan tim" => "tarakan timur",
                    "tarakan bar" => "tarakan barat",
                    "dumoga bar" => "dumoga barat",
                    "dumoga tim" => "dumoga timur",
                    "passi bar" => "passi barat",
                    "passi tim" => "passi timur",
                    "bolaang tim" => "bolaang timur",
                    "langowan tim" => "langowan timur",
                    "langowan bar" => "langowan barat",
                    "langowan sel" => "langowan selatan",
                    "tompaso bar" => "tompaso barat",
                    "kawangkoan bar" => "kawangkoan barat",
                    "tombariri tim" => "tombariri timur",
                    "tondano bar" => "tondano barat",
                    "tondano sel" => "tondano selatan",
                    "lembean tim" => "lembean timur",
                    "tondano tim" => "tondano timur",
                    "manganitu sel" => "manganitu selatan",
                    "tabukan sel" => "tabukan selatan",
                    "tabukan sel tengah" => "tabukan selatan tengah",
                    "tabukan sel tenggara" => "tabukan selatan tenggara",
                    "tahuna tim" => "tahuna timur",
                    "tahuna bar" => "tahuna barat",
                    "melonguane tim" => "melonguane timur",
                    "beo sel" => "beo selatan",
                    "essang sel" => "essang selatan",
                    "motoling bar" => "motoling barat",
                    "motoling tim" => "motoling timur",
                    "amurang bar" => "amurang barat",
                    "amurang tim" => "amurang timur",
                    "likupang bar" => "likupang barat",
                    "likupang tim" => "likupang timur",
                    "likupang sel" => "likupang selatan",
                    "bolang itang tim" => "bolang itang timur",
                    "bolang itang bar" => "bolang itang barat",
                    "siau bar" => "siau barat",
                    "tagulandang sel" => "tagulandang selatan",
                    "siau bar sel" => "siau barat selatan",
                    "siau tim sel" => "siau timur selatan",
                    "siau tim" => "siau timur",
                    "siau bar utara" => "siau barat utara",
                    "amurang bar" => "amurang barat",
                    "amurang tim" => "amurang timur",
                    "ratahan tim" => "ratahan timur",
                    "touluaan sel" => "touluaan selatan",
                    "pinolosian tim" => "pinolosian timur",
                    "lembeh sel" => "lembeh selatan",
                    "tomohon tim" => "tomohon selatan",
                    "tomohon bar" => "tomohon barat",
                    "kotamobagu sel" => "kotamobagu selatan",
                    "kotamobagu tim" => "kotamobagu timur",
                    "kotamobagu bar" => "kotamobagu barat",
                    "banggai sel" => "banggai selatan",
                    "totikum sel" => "totikum selatan",
                    "tinangkung sel" => "tinangkung selatan",
                    "bulagi sel" => "bulagi selatan",
                    "buko sel" => "buko selatan",
                    "toili bar" => "toili barat",
                    "batui sel" => "batui selatan",
                    "luwuk tim" => "luwuk timur",
                    "luwuk sel" => "luwuk selatan",
                    "balantak sel" => "balantak selatan",
                    "bungku sel" => "bungku selatan",
                    "bungku tim" => "bungku timur",
                    "bungku bar" => "bungku barat",
                    "pamona sel" => "pamona selatan",
                    "pamona bar" => "pamona barat",
                    "lore sel" => "lore selatan",
                    "lore bar" => "lore barat",
                    "pamona tim" => "pamona timur",
                    "lore tim" => "lore timur",
                    "poso pesisir sel" => "poso pesisir selatan",
                    "tojo bar" => "tojo barat",
                    "poso kota sel" => "poso kota selatan",
                    "banawa sel" => "banawa selatan",
                    "balaesang tj" => "balaesang tanjung",
                    "dampal sel" => "dampal selatan",
                    "paleleh bar" => "paleleh barat",
                    "parigi sel" => "parigi selatan",
                    "parigi bar" => "parigi barat",
                    "tinombo sel" => "tinombo selatan",
                    "una-una" => "una - una",
                    "kulawi sel" => "kulawi selatan",
                    "dolo sel" => "dolo selatan",
                    "dolo bar" => "dolo barat",
                    "palu bar" => "palu barat",
                    "palu sel" => "tatanga",
                    "palu tim" => "palu timur",
                    "pasimassunggu tim" => "pasimassunggu timur",
                    "bangkala bar" => "bangkala barat",
                    "polombangkeng sel" => "polombangkeng selatan",
                    "galesong sel" => "galesong selatan",
                    "bontonompo sel" => "bontonompo selatan",
                    "bajeng bar" => "bajeng barat",
                    "sinjai bar" => "sinjai barat",
                    "sinjai sel" => "sinjai selatan",
                    "sinjai tim" => "sinjai timur",
                    "tanete riattang bar" => "tanete riattang barat",
                    "tanete riattang tim" => "tanete riattang timur",
                    "suli bar" => "suli barat",
                    "bajo bar" => "bajo barat",
                    "ponrang sel" => "ponrang selatan",
                    "walenrang tim" => "walenrang timur",
                    "walenrang bar" => "walenrang barat",
                    "lamasi tim" => "lamasi timur",
                    "sangala sel" => "sangala selatan",
                    "makale sel" => "makale selatan",
                    "malangke bar" => "malangke barat",
                    "tomoni tim" => "tomoni timur",
                    "bacukiki bar" => "bacukiki barat",
                    "wara sel" => "wara selatan",
                    "wara tim" => "wara timur",
                    "wara bar" => "wara barat",
                    "lasalimu sel" => "lasalimu selatan",
                    "ps wajo" => "pasar wajo",
                    "siompu bar" => "siompu barat",
                    "mawasangka tim" => "mawasangka timur",
                    "tongkuno sel" => "tongkuno selatan",
                    "tiworo sel" => "tiworo selatan",
                    "wakorumba sel" => "wakorumba selatan",
                    "wawonii sel" => "wawonii selatan",
                    "wawonii bar" => "wawonii barat",
                    "wawonii tim" => "wawonii timur",
                    "wawonii tim laut" => "wawonii timur laut",
                    "palangga sel" => "palangga selatan",
                    "ranomeeto bar" => "ranomeeto barat",
                    "kabaena sel" => "kabaena selatan",
                    "kabaena bar" => "kabaena barat",
                    "kabaena tim" => "kabaena timur",
                    "poleang tim" => "poleang timur",
                    "poleang sel" => "poleang selatan",
                    "poleang bar" => "poleang barat",
                    "kaledupa sel" => "kaledupa selatan",
                    "wangi-wangi sel" => "wangi-wangi selatan",
                    "kulisusu bar" => "kulisusu barat",
                    "kendari bar" => "kendari barat",
                    "limboto bar" => "limboto barat",
                    "popayato bar" => "popayato barat",
                    "popayato tim" => "popayato timur",
                    "bulango sel" => "bulango selatan",
                    "bulango tim" => "bulango timur",
                    "suwawa sel" => "suwawa selatan",
                    "suwawa tim" => "suwawa timur",
                    "sumalata" => "sumalata timur",
                    "kota bar" => "kota barat",
                    "kota tim" => "kota timur",
                    "kota sel" => "kota selatan",
                    "banggae tim" => "banggae timur",
                    "bulo" => "b u l o",
                    "rantebulahan tim" => "rantebulahan timur",
                    "tapalang bar" => "tapalang barat",
                    "simboro dan kepulauan" => "simboro",
                    "tanimbar sel" => "tanimbar selatan",
                    "kei kecil bar" => "kei kecil barat",
                    "kei besar utara tim" => "kei besar utara timur",
                    "leihitu bar" => "leihitu barat",
                    "seram utara tim seti" => "seram utara timur seti",
                    "aru sel" => "aru selatan",
                    "aru sel tim" => "aru selatan timur",
                    "central aru" => "aru tengah",
                    "east aru tengah" => "aru tengah timur",
                    "south aru tengah" => "aru tengah selatan",
                    "seram bar" => "seram barat",
                    "huamual belakang" => "huamual",
                    "taniwel tim" => "taniwel timur",
                    "gorom island" => "pulau gorom",
                    "seram tim" => "seram timur",
                    "pp wetar" => "wetar",
                    "babar tim" => "babar timur",
                    "leitimur sel" => "leitimur selatan",
                    "tlk ambon" => "teluk ambon",
                    "pulau dullah sel" => "pulau dullah selatan",
                    "jailolo sel" => "jailolo selatan",
                    "sahu tim" => "sahu timur",
                    "ibu sel" => "ibu selatan",
                    "weda sel" => "weda selatan",
                    "patani bar" => "patani barat",
                    "sula besi bar" => "sula besi barat",
                    "sulabesi sel" => "sulabesi selatan",
                    "sulabesi tim tim" => "sulabesi timur",
                    "mangoli utara tim" => "mangoli utara timur",
                    "mangoli bar" => "mangoli barat",
                    "north mangoli" => "mangoli utara",
                    "south mangoli" => "mangoli selatan",
                    "south obi" => "obi selatan",
                    "west obi" => "obi barat",
                    "east obi" => "obi timur",
                    "mandioli sel" => "mandioli selatan",
                    "bacan sel" => "bacan selatan",
                    "bacan tim" => "bacan timur",
                    "bacan tim sel" => "bacan timur selatan",
                    "bacan bar" => "bacan barat",
                    "kasiruta bar" => "kasiruta barat",
                    "bacan bar utara" => "bacan barat utara",
                    "kayoa bar" => "kayoa barat",
                    "makian bar" => "makian barat",
                    "gane bar" => "gane barat",
                    "gane bar utara" => "gane barat utara",
                    "gane tim" => "gane timur",
                    "gane tim sel" => "gane timur selatan",
                    "kao tlk" => "kao teluk",
                    "kao bar" => "kao barat",
                    "tobelo bar" => "tobelo barat",
                    "tobelo tim" => "tobelo timur",
                    "tobelo sel" => "tobelo selatan",
                    "galela bar" => "galela barat",
                    "galela sel" => "galela selatan",
                    "wasile sel" => "wasile selatan",
                    "wasile tim" => "wasile timur",
                    "morotai sel bar" => "morotai selatan barat",
                    "taliabu bar" => "taliabu barat",
                    "taliabu sel" => "taliabu selatan",
                    "taliabu tim sel" => "taliabu timur selatan",
                    "taliabu bar laut" => "taliabu barat laut",
                    "ternate sel" => "ternate selatan",
                    "tidore sel" => "tidore selatan",
                    "tidore tim" => "tidore timur",
                    "oba sel" => "oba selatan",
                    "fakfak tim" => "fakfak timur",
                    "fakfak bar" => "fakfak barat",
                    "tlk patipi" => "teluk patipi",
                    "arguni bawah" => "teluk arguni bawah",
                    "irorutu / fafurwar" => "fafurwar",
                    "south moskona" => "moskona selatan",
                    "moskona bar" => "moskona barat",
                    "east moskona" => "moskona timur",
                    "west manokwari" => "manokwari barat",
                    "manokwari tim" => "manokwari timur",
                    "manokwari sel" => "manokwari selatan",
                    "salawati sel" => "salawati selatan",
                    "south misool" => "misool selatan",
                    "west misool" => "misool barat",
                    "misool tim" => "misool timur",
                    "waigeo sel" => "waigeo selatan",
                    "west waigeo" => "waigeo barat",
                    "waigeo tim" => "waigeo timur",
                    "north waigeo" => "waigeo utara",
                    "aifat sel" => "aifat selatan",
                    "sorong bar" => "sorong barat",
                    "sorong tim" => "sorong timur",
                    "gresi sel" => "gresi selatan",
                    "sentani tim" => "sentani timur",
                    "tlk umar" => "teluk umar",
                    "nabire bar" => "nabire barat",
                    "tlk kimi" => "teluk kimi",
                    "yapen tim" => "yapen timur",
                    "tlk ampimoi" => "teluk ampimoi",
                    "kurudu island" => "pulau kurudu",
                    "yapen sel" => "yapen selatan",
                    "yapen tim" => "yapen timur",
                    "yerui island" => "pulau yerui",
                    "numfor bar" => "numfor barat",
                    "numfor tim" => "numfor timur",
                    "biak tim" => "biak timur",
                    "biak bar" => "biak barat",
                    "paniai tim" => "paniai timur",
                    "paniai bar" => "paniai barat",
                    "west mimika" => "mimika barat",
                    "mimika bar jauh" => "mimika barat jauh",
                    "mimika tim jauh" => "mimika timur jauh",
                    "central mimika barat" => "mimika barat tengah",
                    "mimika tim" => "mimika timur",
                    "nongme sub-district" => "nongme",
                    "east kiwirok" => "kiwirok timur",
                    "pantai tim bagian bar" => "pantai timur bagian barat",
                    "east pantai" => "pantai timur",
                    "bonggo tim" => "bonggo timur",
                    "sarmi tim" => "sarmi timur",
                    "sarmi sel" => "sarmi selatan",
                    "pantai bar" => "pantai barat",
                    "towe hitam" => "towe",
                    "arso tim" => "arso timur",
                    "supiori sel" => "supiori selatan",
                    "supiori tim" => "supiori timur",
                    "central mamberamo" => "mamberamo tengah",
                    "east mamberamo tengah" => "mamberamo tengah timur",
                    "south sukikai" => "sukikai selatan",
                    "dogiyai" => "dogiyai",
                    "south kamu" => "kamu selatan",
                    "kamu tim" => "kamu timur",
                    "tigi bar" => "tigi barat",
                    "tigi tim" => "tigi timur",
                    "jayapura sel" => "jayapura selatan",
                ];
        
        if(isset($konversi[$districtText])){

            return $konversi[$districtText];
        }
        return $districtText;
    }


    public static function isNew($order_code){
        $model= HistoryPenanganan::model()->find("id = (SELECT max(id) 
                                                        FROM history_penanganan 
                                                        WHERE order_code = '".$order_code."' 
                                                            AND user_id not IN (4, 1229))
                                                AND status_id IN (1, 3, 13)");
        if(empty($model) || ($model->status_id == 3 && $model->user->group->id != 3))
            return false;
        return true;
    }

    public static function getColor($order_code){
   //   $sql = " SELECT A.ms from (SELECT *, max(status_id) as ms FROM `history_penanganan` WHERE status_id in (1,2,5,6,17,22) GROUP BY order_code) as A, user where user.id = A.user_id  AND A.user_id != 4 AND user.username <> 'testing.obat24@gmail.com' AND A.order_code = '".$order_code."' ORDER BY A.id DESC LIMIT 1";
      $sql = "SELECT status_id FROM history_penanganan WHERE order_code = '".$order_code."' ORDER BY id DESC LIMIT 1";
      $hp_id = Yii::app()->db->createCommand($sql)->queryScalar();

      $modelCD = CartDetail::getDataByOrderCode($order_code);
      $cekJam = false;
      if(isset($modelCD->pengiriman_gojek) && !empty($modelCD->pengiriman_gojek))
            $cekJam = true;
      $color = [1 => 'Orange', 2 => 'Blue', 3 => 'Yellow', 4 => 'White', 5 => 'Purple'];
      
      if(isset($modelCD)){
            if($hp_id == 1 || $hp_id == 24 || $hp_id == 25 || $hp_id == 31)
                return $color[1];

            else if($hp_id == 2 || $hp_id == 3 || $hp_id == 4 || $hp_id == 18 || $hp_id == 20)
                return $color[2];
            
            else if($hp_id == 17 && !$cekJam)
                return $color[2];
            
            else if($hp_id == 5 || $hp_id == 6 || $hp_id == 16 || $hp_id == 19)
                return $color[3];
            
            else if($hp_id == 17 && $cekJam)
                return $color[3];
            
            else if($hp_id == 22)
                return $color[5];
      }
      return $color[4];
    }

    public static function isOHD($order_code){
      $sql = " SELECT id from cart_detail where shipping_method = 'UNDER ONE HOUR' AND cart_status_id = 19 AND order_code = '".$order_code."' limit 1";
      $model = Yii::app()->db->createCommand($sql)->queryAll();
      if(empty($model))
        return false;
      return true;
    }


    public static function getStringWaktuPengiriman($rewardId){
        if($rewardId == NULL)
            return "";

        $modelRM = RewardMaster::model()->findByPk($rewardId);
        if($modelRM->time_max == 0){
            return "> ".($modelRM->time_min - 1) ." menit";
        }else{
            return $modelRM->time_min." - ".$modelRM->time_max." menit"; 
        }
    }

    public static function getTotalStatus($status_id){
        $sql = "SELECT COUNT(status_id) AS total, status
            FROM (SELECT b.id, a.order_code, a.status_id AS status_id,a.user_id
            FROM history_penanganan AS a
            INNER JOIN(
            SELECT MAX(id) AS id, order_code
            FROM history_penanganan
            GROUP BY 2 ) AS b
            ON a.id = b.id) AS c INNER JOIN status_penanganan ON c.status_id = status_penanganan.id WHERE c.user_id NOT IN(4, 1229) AND
            status_id = ".$status_id."";
        $model = Yii::app()->db->createCommand($sql)->queryAll();
        $result = array();
        if(!empty($model)){
            foreach ($model as $key) {
                $result = array("total" => $key['total'], "status" => $key['status']);
            }
        }
        return $result;
    }

    public static function getPaymentChannelDoku($id){
        $id = "".$id;
        $data = ['01'=> 'Credit Card Visa/Master IDR',
                 '02'=> 'Mandiri ClickPay',
                 '03'=> 'KlikBCA',
                 '04'=> 'DOKU Wallet',
                 '05'=> 'ATM Permata VA LITE',
                 '06'=> 'BRI e-Pay',
                 '07'=> 'ATM Permata VA',
                 '08'=> 'Mandiri Multipayment LITE',
                 '09'=> 'Mandiri Multipayment',
                 '10'=> 'ATM Mandiri VA LITE',
                 '11'=> 'ATM Mandiri VA',
                 '12'=> 'PayPal',
                 '13'=> 'BNI Debit Online (VCN)',
                 '14'=> 'Alfamart',
                 '15'=> 'Credit Card Visa/Master Multi Currency',
                 '16'=> 'Tokenization',
                 '17'=> 'Recur',
                 '18'=> 'KlikPayBCA',
                 '19'=> 'CIMB Clicks',
                 '20'=> 'PTPOS',
                 '21'=> 'Sinarmas VA FULL',
                 '22'=> 'Sinarmas VA LITE',
                 '23'=> 'MOTO',
                 '25'=> 'Muamalat',
                 '26'=> 'Danamon',
                 '28'=> 'PermataNet',
                 '29'=> 'VA BCA',
                 '41'=> 'VA MANDIRI',
                ];
        if(isset($data[$id]))
             return $data[$id];
        return 'undefined';
    }

    public static function urlHTTP($url){
        if(substr($url, 0, 4) != "http"){
            $url = "http://".$url;
        }
        return $url;
    }


    /*
        getHargaJual tidak untuk perhitungan harga di CARTDETAIL maupun CART. 
        hanya untuk produk yang belum terbeli. 
    */
    public static function getHargaJual($harga, $product){
        $type = Product::model()->findByPk($product)->product_type_id;
        $tuslah = TuslahEmbalase::model()->find("product_type_id = $type")->amount;
        return static::getRupiah( round($harga * (100 + $tuslah)/100 * 1.1) );
    }

    public static function getHargaJualNoFormat($harga, $product){
        $type = Product::model()->findByPk($product)->product_type_id;
        $tuslah = TuslahEmbalase::model()->find("product_type_id = $type")->amount;
        return round($harga * (100 + $tuslah)/100 * 1.1);
    }

    public static function encrypt($text)
    {
        $salt ='obat24S4L4Msehat';
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public static function decrypt($text)
    {
        $salt ='obat24S4L4Msehat';
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    public static function validateSurveyId($id){
        
        $id = preg_replace('/--/', '%25', $id);
        $unique = VFormatter::decrypt(urldecode(urldecode($id)));
        if(preg_match('/#/', $unique) && (strlen($unique) >= 17 && strlen($unique) <= 19)) {
            $data = explode("#", $unique);
            $time = strtotime($data[1]);
            $date = date('Y-m-d',$time);

            $intervalNum = EnvironmentVariable::getValue('NPS_KEDALUWARSA', 2);
            $limitMaxDate = new DateTime($date);
            $interval = new DateInterval('P' . $intervalNum . 'D');
            $limitMaxDate = $limitMaxDate->add($interval);

            $order_code = $data[0];
            $model = CartDetail::model()->findByAttributes(array('order_code' => $order_code));         
            $modelCheck = Survey::model()->findByAttributes(array('order_code' => $order_code));         
            
            $date = date('Y-m-d');
            $now = new DateTime($date);
            
            if($limitMaxDate >= $now && isset($model->attributes) && (!isset($modelCheck->attributes)  || isset($modelCheck->attributes) && $modelCheck->comment == "") ){
                return true;
            }else{
                 return false;
            }
        }else{
            return false;
        }
    }

    public static function getSurveyId($id){
        $id = preg_replace('/--/', '%25', $id);
        $unique = VFormatter::decrypt(urldecode(urldecode($id)));
        $data = explode("#", $unique);
        return $data;
    }

    public static function validateInputNoResiId($id) {
        $id = preg_replace('/24k-ina/', '%25', $id);
        $unique = VFormatter::decrypt(urldecode(urldecode($id)));
        if (preg_match('/#/', $unique) && (strlen($unique) >= 23 && strlen($unique) <= 29)) {
            $data = explode("#", $unique);
            $time = strtotime($data[2]);
            $date = date('Y-m-d',$time);

            $next_week = new DateTime($date);
            $interval = new DateInterval('P1W');
            $next_week = $next_week->add($interval);

            $order_code = $data[0];
            $model = CartDetail::model()->findByAttributes(array('order_code' => $order_code));

            $date = date('Y-m-d');
            $now = new DateTime($date);

            if ($next_week >= $now && isset($model->attributes))
                return true;
            else
                return false;
        } else {
            return false;
        }
    }

    public static function getInputNoResiId($id){
        $id = preg_replace('/24k-ina/', '%25', $id);
        $unique = VFormatter::decrypt(urldecode(urldecode($id)));
        $data = explode("#", $unique);
        return $data;
    }

    public static function getRupiah($number) {
        return number_format($number, 0, ",", ".");
    }

    public static function getRupiah2($number) {
        return number_format( intval($number) , 0, ".", ",");
    }

    public static function getReadmore($text) {
        $text = explode('[excerpt]', $text);
        $excerpt = $text[0];
        return $excerpt;
    }

    public static function getEncodeEmail($text){
        $arrText = str_split($text);
        $hasil = "";
        foreach ($arrText as $key) {
            $nkey = ord($key);
            $nkey = dechex($nkey);
            $hasil .= '&#x'.$nkey.';';
        }

        return $hasil;
    }

    public static function getView($text) {
        $excerpt = str_replace('[excerpt]', '', $text);
        return $excerpt;
    }

    public static function getSeoTitle($title){
        $title = strtolower($title);
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%');
        $title = str_replace($regex, '-', $title);
        return $title;
    }

    public static function getSeoTitleProduct($title){
        $title = strtolower($title);
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%');
        $title = str_replace($regex, ' ', $title);
        return $title;
    }


    public static function getSeo($title) {    
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%');
        $title = str_replace($regex, '-', $title);
        return $title;
    }

    public static function getClearName($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', '%', '\'');
        $title = str_replace($regex, '', $title);
        $regex = array(',');
        $title = str_replace($regex, '.', $title);
        return $title;
    }

    public static function getClearKoma($title) {
        $regex = array('\'');
        $title = str_replace($regex, '', $title);
        return $title;
    }

    public static function getClearSpasi($title) {
        $regex = array(' ');
        $title = str_replace($regex, '', $title);
        $title = strtolower($title);
        return $title;
    }

    public static function getClear($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%', '-');
        $title = str_replace($regex, '', $title);
        $title = strtolower($title);
        return $title;
    }

    public static function getClear2($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', ' ', '%', '-', ',');
        $title = str_replace($regex, '', $title);
        $title = strtolower($title);
        return $title;
    }

    public static function getSpasi($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', '%', '-', '&', ',');
        $title = str_replace($regex, ' ', $title);
        $title = preg_replace("/\s+/", "+", $title);
        $title = strtolower($title);
        return $title;
    }

    public static function getSpasiSeo($title) {
        $regex = array(':', '\\', '/', '*', '+', '_', '%', '-', '&', ',');
        $title = str_replace($regex, ' ', $title);
        $title = preg_replace("/\s+/", "-", $title);
        $title = strtolower($title);
        return $title;
    }

    public static function formatDate($oldDate, $divider = '/', $dividerTo = '-') {
        $arr = explode($divider, $oldDate);
        $newDate = $arr[2] . $dividerTo . $arr[1] . $dividerTo . $arr[0];
        return str_replace(' ', '', $newDate);
    }

    public static function nomorRomawi($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    public static function showDayName($date){
        $date = date('N', strtotime($date));
        $hari = array ( 1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
        return $hari[$date];
    }

    public static function detailDate($date){
        $dateExplode = explode('-', $date);

        $bln = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $bulan = date('n', strtotime($date));
        $dateBulan = $bln[$bulan];

        return date('j', strtotime($date))." ".$dateBulan." ".$dateExplode[0];
    }

    public static function detailDateShort($date){
        $dateExplode = explode('-', $date);

        $bln = array("","Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des");
        $bulan = date('n', strtotime($date));
        $dateBulan = $bln[$bulan];

        return date('j', strtotime($date))." ".$dateBulan." ".$dateExplode[0];
    }

    public static function detailDateRange($date1, $date2, $formatted = false){
        if (!$formatted) {
            $date1 = strtotime($date1);
            $date2 = strtotime($date2);
        }

        $namaBulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        if (date('Y', $date1) == date('Y', $date2)) {
            if (date('m', $date1) == date('m', $date2)) {
                if (date('d', $date1) == date('d', $date2)) {
                    return date('j', $date1) . " " . $namaBulan[date('n', $date1)] . " " . date('Y', $date1);
                } else {
                    return date('j', $date1) . " - " . date('j', $date2) . " " . $namaBulan[date('n', $date1)] . " " . date('Y', $date1);
                }
            } else {
                return date('j', $date1) . " " . $namaBulan[date('n', $date1)] . " - " . date('d', $date2) . " " . $namaBulan[date('n', $date2)] . " " . date('Y', $date1);
            }
        } else {
            return date('j', $date1) . " " . $namaBulan[date('n', $date1)] . " " . date('Y', $date1) .
                " - " .
                date('j', $date2) . " " . $namaBulan[date('n', $date2)] . " " . date('Y', $date2);
        }
    }

    public static function getUniqueCode($str) {
        $newOrderCode = "";
        $unique = false;
        while ($unique == false) {
            $newOrderCode = substr(sha1($str), 0, rand(6, 8));
            if (count(Yii::app()->db->createCommand("SELECT id FROM cart_detail WHERE order_code = '" . $newOrderCode . "' LIMIT 1")->queryAll()) <= 0) {
                $unique = true;
            }
        }
        return $newOrderCode;
    }
    
    public static function getBankMandiriAccountNumber(){
        return " 137-00-2400002-4";                    
    }

    public static function getBankMandiriKantorCabang(){
        return " KCP Godean Yogyakarta";
    }
    
    public static function getBankMandiriAtasNama(){
        return " PT. K24 Klik Indonesia";
    }

    public static function getBankBCAAccountNumber(){
        return " 037-560-9555";
    }

    public static function getBankBCAKantorCabang(){
        return " KCP Pingit Yogyakarta";
    }
    
    public static function getBankBCAAtasNama(){
        return " PT. K24 Klik Indonesia";
    }

    public static function getBankBNIAccountNumber(){
        return " 887-887-0024";                    
    }

    public static function getBankBNIKantorCabang(){
        return " KCP Jl. Magelang";
    }
    
    public static function getBankBNIAtasNama(){
        return " PT. K24 Klik Indonesia";
    }

    public static function getBankBRIAccountNumber(){
        return " 0410-01-000338-30-7";                    
    }

    public static function getBankBRIKantorCabang(){
        return " KC Adisucipto Yogyakarta";
    }
    
    public static function getBankBRIAtasNama(){
        return " PT. K24 Klik Indonesia";
    }
    
    public static function getCekSpamMessage(){
        return "<p>
<i>Apabila anda tidak mendapatkan email dari kami, mohon cek folder Spam/Junk
        Anda terlebih dahulu, atau hubungi Team Support <a href='mailto:customercare@k24klik.com'>K24klik.com (customercare@k24klik.com)</i></a>.
</p>";
    }


    public static function getBannerStatus($id){
        date_default_timezone_set("Asia/Jakarta");
        $banner = Banner::model()->findByPk($id);
        if(isset($banner->start_date) && isset($banner->end_date) && isset($banner->start_hour) && isset($banner->end_hour) && 
            ($banner->start_date != null || $banner->start_date != null) ){

                $date = Date('Y-m-d');
                if(strtotime($banner->start_date) <= strtotime($date) &&
                    strtotime($date) <= strtotime($banner->end_date)) {
                    
                    $time = Date('H:i:s');
                    $time = strtotime($time);
                    $min_time = strtotime("00:00:00");
                    $max_time = strtotime("23:59:59");
                    if($banner->start_hour != NULL && $banner->end_hour != NULL){
                        if($time >= strtotime($banner->start_hour) && $time <= strtotime($banner->end_hour))    
                            return true;
                        else
                            return false;
                    }else if($banner->start_hour != NULL ){

                        if($time >= strtotime($banner->start_hour) && $time <= $max_time)    
                            return true;
                        else
                            return false;
                    }else if($banner->end_hour != NULL ){

                        if($time >= $min_time && $time <= strtotime($banner->end_hour) )    
                            return true;
                        else
                            return false;
                    }else{
                        return true;
                    }

                }else{
                    return false;
                }
            }
        return false;
            
    }

    public static function getKodeVerifikasi($orderCode, $tag = "") {
        $cartDetail = CartDetail::getDataByOrderCode($orderCode);
        if (isset($cartDetail)) {
            $total = $cartDetail->total_price;
            if ($tag != "Ya. antar dengan KURIR OUTLET")
                $total -= $cartDetail->shipping_costs;
            /* pindah di bawah
            if (isset($cartDetail->packing_kayu))
                $total -= $cartDetail->packing_kayu;
            */

            $cartDelivery = CartDelivery::model()->find("cart_detail_id = $cartDetail->id");
            if (isset($cartDelivery) && ($cartDetail->shipping_method == "LANGSUNG"
                || $cartDetail->shipping_method == "UNDER ONE HOUR")) {
                $sqlStatus = "SELECT hp.status_id FROM (SELECT MAX(id) AS id 
                        FROM history_penanganan WHERE order_code = '$orderCode' 
                        AND (status_id IN (5,16,17,19))) a 
                        JOIN history_penanganan hp ON a.id = hp.id";
                $status = Yii::app()->db->createCommand($sqlStatus)->queryAll();
                if (count($status) > 0 && $status[0]['status_id'] != 17) {
                    $total = $cartDetail->total_price + $cartDelivery->nominal;
                }
            }

            $paymentMethods = ["DOKU","ATM BERSAMA","KARTU KREDIT","OCBC","MANDIRI CLICKPAY","BNI DEBIT ONLINE",
                "DANAMON","MUAMALAT","BUKOPIN","MAYBANK","PROMO UOB","PROMO BNI","PERMATANET","MSAKU","BEBASBAYAR","FASPAY_BRI",
                "CIMB CLICK","VA BCA","VA MANDIRI", Constant::PAYMENT_VA_BNI, Constant::PAYMENT_GOPAY, Constant::PAYMENT_DANA];
            if (in_array($cartDetail->payment_method, $paymentMethods))
                $total -= $cartDetail->biaya_admin;

            $usedVoucher = null;
            $voucherCode = "-";
            $cartVoucher = CartVoucher::model()->find("cart_detail_id = $cartDetail->id");
            if (isset($cartVoucher->id)) {
                $voucherCode = $cartVoucher->kode_voucher;
                if ($cartVoucher->source == 'voucher outlet') {
                    $voucher = VoucherOutlet::model()->findByAttributes(['kode_voucher'=>$cartVoucher->kode_voucher, 'user_id'=>$cartDetail->user_id]);
                } else if (isset($cartVoucher->nominal)) {
                    $voucher = Voucher::model()->find("kode_voucher = '$voucherCode'");
                    $voucherOpen = VoucherOpen::model()->find("kode_voucher = '$voucherCode'");
                    $voucherBersama = VoucherBersama::model()->find("kode_voucher = '$voucherCode'");
                    $voucherProduct = VoucherProduct::model()->find("kode_voucher = '$voucherCode'");
                } elseif (isset($cartVoucher->biaya_ongkir)) {
                    $promoDeliveryFee = PromoDeliveryFee::model()->find("kode_promo = '$voucherCode'");
                    $promoBersamaDeliveryFee = PromoBersamaDeliveryFee::model()->find("kode_promo = '$voucherCode'");
                }

                if (isset($voucher))
                    $usedVoucher = $voucher;
                elseif (isset($voucherBersama))
                    $usedVoucher = $voucherBersama;
                else if (isset($voucherProduct))
                    $usedVoucher = $voucherProduct;
                else if (isset($voucherOpen))
                    $usedVoucher = $voucherOpen;
                else if (isset($promoDeliveryFee))
                    $usedVoucher = $promoDeliveryFee;
                else if (isset($promoBersamaDeliveryFee))
                    $usedVoucher = $promoBersamaDeliveryFee;

                if ($cartVoucher->biaya_ongkir == null) {
                    if (isset($cartVoucher->nominal))
                        $total += $cartVoucher->nominal;
                    else if (isset($usedVoucher)) {
                        if (isset($usedVoucher->category->persen))
                            $total += round($cartVoucher->biaya_ongkir * ($usedVoucher->category->persen/100));
                        else
                            $total += $usedVoucher->category->nominal;
                    }
                }
            }

            $totalReal = 0;
            $totalDiskonOutlet = 0;
            $totalDiskonK24klik = 0;

            $cartBingkisan = CartBingkisan::model()->findAll("id_cart_detail = $cartDetail->id");
            foreach ($cartBingkisan as $cb) {
                $totalDiskonK24klik += ($cb->potongan_bingkisan * $cb->qty);
            }

            $promoOutletForBingkisan = 0;
            foreach ($cartDetail->carts as $cart) {
                $tuslah = (100 + $cart->tuslah) / 100;
                $tuslah2 = (100 + $cart->tuslah) / 100 * 1.1;

                // $totalReal += $cart->price;
                $totalReal += round($cart->unit_price_before * $tuslah2) * $cart->qty;
                $jenisPromo = (isset($cart->jenis_promo) ? $cart->jenis_promo : "none");
                $unitPriceK24klik = $cart->unit_price_before * $tuslah - $cart->unit_price_after * $tuslah;
                if ($unitPriceK24klik != 0) {
                    if ($jenisPromo == "OUTLET") {
                        $potongan = $unitPriceK24klik * $cart->qty;
                        if (isset($cartDetail->outlet) && $cartDetail->outlet->pkp == 0)
                            $potongan = round($potongan * 1.1);

                        $totalDiskonOutlet += $potongan;
                    } elseif ($jenisPromo == "OBAT24" || $jenisPromo == "CLIENT") {
                        $totalDiskonK24klik += (round($cart->unit_price_before * $tuslah2) - round($cart->unit_price_after * $tuslah2)) * $cart->qty;
                    }
                }

                if (isset($cart->id_bingkisan)) {
                    $ppo = ProductPromoOutlet::model()->find(
                        "DATE(promotion_end_date) > DATE(NOW()) 
                                AND product_id = $cart->product_id");
                    if (isset($ppo) && isset($ppo->outlet_ids)) {
                        $arrayOutletPPO = explode(",", $ppo->outlet_ids);
                        if (in_array($cartDetail->outlet_id, $arrayOutletPPO)) {
                            $potonganPPO = round(($ppo->price_before_diskon * 1.1) - ($ppo->price_after_diskon * 1.1) * $cart->qty);
                            $promoOutletForBingkisan += $potonganPPO;
                        }
                    }
                }
            }

            $mod = $totalReal % 100;
            if ($mod > 0) {
                $totalReal = ceil($totalReal / 100) * 100;
            }

            if (isset($cartDetail->potongan_point) && $cartDetail->potongan_point != null
                && $cartDetail->potongan_point > 0) {
                $total -= $cartDetail->potongan_point;
                $totalDiskonK24klik += $cartDetail->potongan_point;
            }

            $totalEnc = $total;
            $sisaPotonganPromo = 0;
            if (isset($usedVoucher) && (isset($usedVoucher->category->nominal)
                || isset($usedVoucher->category->persen))) {
                if ($cartVoucher->biaya_ongkir != null) {
                    $isOjekOnline = false;
                    $sqlStatusOjekOnline = "SELECT hp.status_id FROM (SELECT MAX(id) AS id 
                        FROM history_penanganan WHERE order_code = '$orderCode' 
                        AND (status_id IN (5,6,17))) a 
                        JOIN history_penanganan hp ON a.id = hp.id";
                    $statusOjekOnline = Yii::app()->db->createCommand($sqlStatusOjekOnline)->queryAll();
                    if (count($statusOjekOnline) > 0 && $statusOjekOnline[0]['status_id'] == 17)
                        $isOjekOnline = true;

                    $nominalPromo = 0;
                    if (isset($usedVoucher->category->persen))
                        $nominalPromo += round($cartVoucher->biaya_ongkir * ($usedVoucher->category->persen/100));
                    else
                        $nominalPromo = $usedVoucher->category->nominal;
                    if ($nominalPromo > $cartVoucher->biaya_ongkir) {
                        $sisaPotonganPromo = $nominalPromo - $cartVoucher->biaya_ongkir;
                        $nominalPromo = $cartVoucher->biaya_ongkir;
                    }

                    if ($cartDetail->shipping_method == "PAKET"
                        || (($cartDetail->shipping_method == "LANGSUNG"
                        || $cartDetail->shipping_method == "UNDER ONE HOUR")
                        && $isOjekOnline)) {
                        // $totalDiskonK24klik = 0;
                        $voucherCode = "-";
                    } else {
                        $totalDiskonK24klik += $nominalPromo;
                    }

                } else {
                    if (isset($cartVoucher->nominal)) {
                        $totalDiskonK24klik += $cartVoucher->nominal;
                        $totalEnc -= $cartVoucher->nominal;
                    } else {
                        $totalDiskonK24klik += $usedVoucher->category->nominal;
                        $totalEnc -= $usedVoucher->category->nominal;
                    }

                }
            }

            if (isset($cartDetail->packing_kayu))
                $totalEnc -= max(0, ($cartDetail->packing_kayu - $sisaPotonganPromo));

            if ($promoOutletForBingkisan > 0)
                $totalDiskonK24klik -= $promoOutletForBingkisan;

            if ($cartDetail->payment_method == "TRANSFER BCA") {
                $kodeBCA = substr($totalEnc, -2);
                $totalEnc -= $kodeBCA;
            }

            if (isset($cartDetail->potongan))
                $totalDiskonK24klik += $cartDetail->potongan;

            $name = $cartDetail->name;
            $kuitansi = Kuitansi::model()->find("order_code = '$cartDetail->order_code'");
            if (isset($kuitansi))
                $name .= " (kuitansi terlampir)";


            $addDokterSiaga = false;
            $modelDokterSiaga = Doktersiaga::model()->findByAttributes(['order_code' => $cartDetail->order_code]);
            if (isset($modelDokterSiaga) && isset($modelDokterSiaga->invoice_id) && !empty($modelDokterSiaga->invoice_id)) {
                if (isset($cartDetail->client) && $cartDetail->client->name == "DOKTER SIAGA") {
                    // OFFLINE
                    $addDokterSiaga = true;
                } else if ($cartDetail->payment_method == Constant::PAYMENT_COD) {
                    // ONLINE COD
                    $addDokterSiaga = true;
                } else {
                    // ONLINE TRANSFER
                    $totalEnc = $totalEnc - max(0, $modelDokterSiaga->biaya_dokter)
                        - max(0, $modelDokterSiaga->biaya_k24klik)
                        - max(0, $modelDokterSiaga->biaya_apotek)
                        - max(0, $modelDokterSiaga->biaya_associate);
                }
            }

            if (isset($cartDetail->shipping_method, $cartDetail->bubble_wrap) && $cartDetail->shipping_method == "PAKET"){
                if (isset($cartDetail->ongkir_pasien)){
                    if (($cartDetail->ongkir_pasien - $cartDetail->bubble_wrap) > 0)
                        $totalEnc -= $cartDetail->bubble_wrap;
                    else
                        $totalEnc -= $cartDetail->ongkir_pasien; //nilai sisa bubble wrap
                } else
                    $totalEnc -= $cartDetail->bubble_wrap;
            }

            if ($totalEnc < 0)
                $totalEnc = 0;

            if ($tag != "Ya. antar dengan KURIR OUTLET"
                && $totalEnc == 0 && $totalDiskonK24klik > $totalReal)
                $totalDiskonK24klik = $totalReal;

            $enc = "#".$cartDetail->order_code."#".$name."#"
                .$totalEnc."#".$voucherCode."#".$totalDiskonK24klik;

            if ($addDokterSiaga) {
                $enc .= "#" . $modelDokterSiaga->invoice_id;
            } else {
                $enc .= "#-";
            }

            $enc = base64_encode($enc);

            return $enc;
        } else {
            return "#";
        }
    }

    public static function getKodeVerifikasiOld($order_code, $tag = ""){
        $modelOrder = CartDetail::model()->find(' order_code = "'. $order_code . '"');
        if (isset($modelOrder)) {
            $modelVoucher = CartVoucher::model()->find("cart_detail_id = " . $modelOrder->id);
            $shipcost = 0;
            $total = 0;

            $totalTanpaShipping = $modelOrder->total_price;
            if (isset($modelOrder->shipping_costs))
                $totalTanpaShipping = $modelOrder->total_price - $modelOrder->shipping_costs;
            if (isset($modelOrder->packing_kayu))
                $totalTanpaShipping -= $modelOrder->packing_kayu;

            // promo delivery tanpa voucher
            $promoDeliveryTanpaVoucher = CartDelivery::model()->find("cart_detail_id = " . $modelOrder->id);

            if ($modelOrder->shipping_method == 'LANGSUNG' || $modelOrder->shipping_method == 'UNDER ONE HOUR') {
                $sql = "SELECT hp.* FROM (SELECT MAX(id) AS id FROM history_penanganan WHERE order_code = '" . $order_code . "' AND (status_id IN (5,16,17,19))) a JOIN history_penanganan hp ON a.id = hp.id";
                $hp = Yii::app()->db->createCommand($sql)->queryAll();
                if (count($hp) > 0 && $hp[0]['status_id'] != 17) {
                    if (isset($promoDeliveryTanpaVoucher))
                        $total = $modelOrder->total_price + $promoDeliveryTanpaVoucher->nominal;
                    else
                        $total = $modelOrder->total_price;
                } else {
                    if ($tag != "Ya. antar dengan KURIR OUTLET")
                        $total = $modelOrder->total_price - $modelOrder->shipping_costs;
                }
            } else {
                if ($tag != "Ya. antar dengan KURIR OUTLET")
                    $total = $modelOrder->total_price - $modelOrder->shipping_costs;

                if (isset($modelOrder->packing_kayu))
                    $total -= $modelOrder->packing_kayu;
            }

            if ($modelOrder->payment_method == 'DOKU' ||
                $modelOrder->payment_method == 'ATM BERSAMA' ||
                $modelOrder->payment_method == 'KARTU KREDIT' ||
                $modelOrder->payment_method == 'OCBC' ||
                $modelOrder->payment_method == 'MANDIRI CLICKPAY' ||
                $modelOrder->payment_method == 'BNI DEBIT ONLINE' ||
                $modelOrder->payment_method == 'DANAMON' ||
                $modelOrder->payment_method == 'MUAMALAT' ||
                $modelOrder->payment_method == 'BUKOPIN' ||
                $modelOrder->payment_method == 'MAYBANK' ||
                $modelOrder->payment_method == 'PROMO UOB' ||
                $modelOrder->payment_method == "PROMO BNI" ||
                $modelOrder->payment_method == "PERMATANET" ||
                $modelOrder->payment_method == "MSAKU" ||
                $modelOrder->payment_method == "BEBASBAYAR" ||
                $modelOrder->payment_method == "FASPAY_BRI" ||
                $modelOrder->payment_method == "CIMB CLICK" ||
                $modelOrder->payment_method == "VA BCA" ||
                $modelOrder->payment_method == Constant::PAYMENT_VA_BNI ||
                $modelOrder->payment_method == Constant::PAYMENT_VA_MANDIRI ||
                $modelOrder->payment_method == Constant::PAYMENT_GOPAY ||
                $modelOrder->payment_method == Constant::PAYMENT_DANA) {
                $total = $total - $modelOrder->biaya_admin;
            }

            $mdlVoucher = null;
            if (isset($modelVoucher->id)) {
                if (isset($modelVoucher->nominal)) {
                    $voucher = Voucher::model()->find('kode_voucher = "' . $modelVoucher->kode_voucher . '"');
                    $voucherOpen = VoucherOpen::model()->find('kode_voucher = "' . $modelVoucher->kode_voucher . '"');
                    $voucherBersama = VoucherBersama::model()->find('kode_voucher = "' . $modelVoucher->kode_voucher . '"');
                    $voucherProduct = VoucherProduct::model()->find('kode_voucher = "' . $modelVoucher->kode_voucher . '"');
                } else if (isset($modelVoucher->biaya_ongkir)) {
                    $promo = PromoDeliveryFee::model()->find('kode_promo = "' . $modelVoucher->kode_voucher . '"');
                    $promoBersama = PromoBersamaDeliveryFee::model()->find('kode_promo = "' . $modelVoucher->kode_voucher . '"');
                }

                if (isset($voucher)) {
                    $mdlVoucher = $voucher;
                } else if (isset($voucherBersama)) {
                    $mdlVoucher = $voucherBersama;
                } else if (isset($voucherProduct)) {
                    $mdlVoucher = $voucherProduct;
                } else if (isset($voucherOpen)) {
                    $mdlVoucher = $voucherOpen;
                } else if (isset($promo)) {
                    $mdlVoucher = $promo;
                } else if (isset($promoBersama)) {
                    $mdlVoucher = $promoBersama;
                }

            }

            // echo $total.' - ';

            $kdVoucher = "";
            if (isset($modelVoucher->id)) {
                if ($modelVoucher->biaya_ongkir == null) {
                    if (isset($modelVoucher->nominal)) {
                        $total = $total + $modelVoucher->nominal;
                    } elseif (isset($mdlVoucher)) {
                        $total = $total + $mdlVoucher->category->nominal;
                    }
                }
                $kdVoucher = $modelVoucher->kode_voucher;
            }

            // echo $total;
            $modelLocation = Location::model()->findByPk($modelOrder->outlet_id);
            $sql = "";
            if (isset($modelLocation) && $modelLocation->master_baru == false) {
                $sql = " SELECT p.id, p.product_code, p.name
                    ,c.qty,CASE WHEN product_type_id=3 THEN s.name ELSE m.name END AS unit_sell, c.satuan
                    ,p.unit_price,c.price as subtotal, c.id_bingkisan
                    ,c.unit_price_after, c.unit_price_before, c.tuslah, c.jenis_promo
            FROM (select c.id,c.product_id,c.qty,c.price,c.cart_detail_id,c.unit_price_after, c.unit_price_before, c.tuslah, c.jenis_promo, c.id_bingkisan, c.satuan from cart c) as c
                INNER JOIN product p ON c.product_id = p.id
                INNER JOIN unit m ON m.id = p.mid_unit
                INNER JOIN unit s ON s.id = p.sell_unit
            WHERE c.cart_detail_id = " . $modelOrder->id . "";
            } else {
                $sql = " SELECT p.id, case when pb.product_code is not null then pb.product_code else p.product_code end as product_code, p.name
                    ,c.qty,CASE WHEN product_type_id=3 THEN s.name ELSE m.name END AS unit_sell, c.satuan
                    ,p.unit_price,c.price as subtotal, c.id_bingkisan
                    ,c.unit_price_after, c.unit_price_before, c.tuslah, c.jenis_promo
            FROM (select c.id,c.product_id,c.qty,c.price,c.cart_detail_id,c.unit_price_after, c.unit_price_before, c.tuslah, c.jenis_promo, c.id_bingkisan, c.satuan from cart c) as c
                INNER JOIN product p ON c.product_id = p.id
                INNER JOIN unit m ON m.id = p.mid_unit
                INNER JOIN unit s ON s.id = p.sell_unit
                LEFT JOIN product_baru pb ON pb.product_id = p.id
            WHERE c.cart_detail_id = " . $modelOrder->id . "";
            }

            $data = Yii::app()->db->createCommand($sql)->queryAll();
            $dataTemp = $data;
            $totalDiskonOutlet = 0;
            $totalDiskonObat24 = 0;

            // cek potongan bingkisan
            $idCD = CartDetail::getDataByOrderCode($order_code)->id;
            $cartBingkisan = CartBingkisan::model()->findAll("id_cart_detail = " . $idCD);
            foreach ($cartBingkisan as $cartBingkisan_) {
                $totalDiskonObat24 += ($cartBingkisan_->potongan_bingkisan * $cartBingkisan_->qty);
            }

            $totalReal = 0;
            foreach ($data as $data) {
                $totalReal = $totalReal + $data['subtotal'];
                $tuslah = $data['tuslah'];

                if (!isset($data['jenis_promo'])) $data['jenis_promo'] = 'none';
                if ($data['unit_price_before'] * (100 + $tuslah) / 100 - $data['unit_price_after'] * (100 + $tuslah) / 100 != 0):
                    if ($data['jenis_promo'] == 'OUTLET') {

                        $potongan = ($data['unit_price_before'] * (100 + $tuslah) / 100 - $data['unit_price_after'] * (100 + $tuslah) / 100) * $data['qty'];
                        $modelLocation = Location::model()->findByPk($modelOrder->outlet_id);
                        if (isset($modelLocation) && $modelLocation->pkp == 0)
                            $potongan = $potongan * 1.1;
                        $totalDiskonOutlet += $potongan;
                        $potongan = round($potongan);

                    } else if ($data["jenis_promo"] == 'OBAT24') {
                        $totalDiskonObat24 += (ROUND($data['unit_price_before'] * (100 + $tuslah) / 100 * 1.1) - ROUND($data['unit_price_after'] * (100 + $tuslah) / 100 * 1.1)) * $data['qty'];
                    } else if ($data["jenis_promo"] == 'CLIENT') {
                        $totalDiskonObat24 += (ROUND($data['unit_price_before'] * (100 + $tuslah) / 100 * 1.1) - ROUND($data['unit_price_after'] * (100 + $tuslah) / 100 * 1.1)) * $data['qty'];
                    }

                endif;
            }

            $mod_amount = $totalReal % 100;
            if ($mod_amount > 0) {
                $totalReal = (ceil($totalReal / 100) * 100);
            }

            // return $totalDiskonObat24;
            // $totalDiskonObat24 = round($totalDiskonObat24 * 1.1);
            $kodeVoucher = "-";
            if ($kdVoucher != "") $kodeVoucher = $kdVoucher;

            if (isset($modelOrder->potongan_point) && $modelOrder->potongan_point != null && $modelOrder->potongan_point > 0) {
                $total -= $modelOrder->potongan_point;
                $totalDiskonObat24 += $modelOrder->potongan_point;
            }

            $totalEnc = $total;
            if (isset($mdlVoucher->category->nominal) || isset($mdlVoucher->category->persen)) {
                if ($modelVoucher->biaya_ongkir != null) {
                    $isOjekOnline = false;
                    $statusOjekOnline = HistoryPenanganan::model()->findAll("order_code = '" . $order_code . "' AND status_id = 17 ORDER BY id LIMIT 1");
                    $statusKurirOutlet = HistoryPenanganan::model()->findAll("order_code = '" . $order_code . "' AND (status_id = 5 OR status_id = 6) ORDER BY id LIMIT 1");

                    if (count($statusOjekOnline) > 0 && count($statusKurirOutlet) > 0) {
                        if ($statusOjekOnline[0]->id > $statusKurirOutlet[0]->id)
                            $isOjekOnline = true;
                    } elseif (count($statusOjekOnline) > 0) {
                        $isOjekOnline = true;
                    }

                    if ($modelOrder->shipping_method == "PAKET" || (($modelOrder->shipping_method == "LANGSUNG" || $modelOrder->shipping_method == "UNDER ONE HOUR") && $isOjekOnline)) {
                        $totalDiskonObat24 = 0;
                        $kodeVoucher = "-";
                    } else if ($mdlVoucher->category->nominal > 0 && $mdlVoucher->category->nominal < $modelVoucher->biaya_ongkir) {
                        $totalDiskonObat24 += $mdlVoucher->category->nominal;
                        // $totalEnc -=  $mdlVoucher->category->nominal;
                    } else {
                        $totalDiskonObat24 += $modelVoucher->biaya_ongkir;
                        // $totalEnc -=  $modelVoucher->biaya_ongkir;
                    }
                } else {
                    if (isset($modelVoucher->nominal)) {
                        $totalDiskonObat24 += $modelVoucher->nominal;
                        $totalEnc -= $modelVoucher->nominal;
                    } else {
                        $totalDiskonObat24 += $mdlVoucher->category->nominal;
                        $totalEnc -= $mdlVoucher->category->nominal;
                    }

                }
            }

            // cek metode transfer BCA
            if ($modelOrder->payment_method == 'TRANSFER BCA') {
                $kodeBCA = substr($totalEnc, -2);
                $totalEnc -= $kodeBCA;
            }

            if (isset($modelOrder->potongan))
                $totalDiskonObat24 += $modelOrder->potongan;

            if ($totalEnc < 0)
                $totalEnc = 0;

            // echo $totalEnc; exit();

            // diskon = total bila diskon > total
            if ($tag != "Ya. antar dengan KURIR OUTLET"
                && $totalEnc == 0 && $totalDiskonObat24 > $totalReal)
                $totalDiskonObat24 = $totalReal;

            $subject = 'Pemesanan Obat dengan kode #' . $modelOrder->order_code . '';
            $enc = base64_encode('#' . $modelOrder->order_code . '#' . $modelOrder->name . '#' . $totalEnc . '#' . $kodeVoucher . '#' . $totalDiskonObat24);

            return $enc;
        } else {
            return "#";
        }
    }

    public static function encryptKonfirmasiKirim($ordercode, $outlet_id, $options = 'Ya', $orderby = NULL){
        // $x =  base64_encode('8666e1e6084d;76');
        // $y = $x.sha1('K24');
        // $z = base64_encode($y);
        try {
            if($orderby != null)
                $x = base64_encode($ordercode . ';'. $outlet_id . ';'. VFormatter::getKodeVerifikasi($ordercode) . ';' . $options. ';' . $orderby);
            else
                $x = base64_encode($ordercode . ';'. $outlet_id . ';'. VFormatter::getKodeVerifikasi($ordercode) . ';' . $options);
            $y = $x.sha1('K24');
            $z = base64_encode($y);

            return $z;    
        } catch (Exception $e) {
            return null;
        }
    }

    public static function decryptKonfirmasiKirim($string){
        try {
            $first = base64_decode($string);
            $second = explode(sha1('K24'),$first);
            $data = base64_decode($second[0]);    

            $data = explode(';', $data);
            if($data != null){
                return $data;    
            }else{
                return null;
            }

            
        } catch (Exception $e) {
            return null;
        }
    }


    public static function encryptBatalKirim($ordercode, $outlet_id, $user, $jenis){
        // $x =  base64_encode('8666e1e6084d;76');
        // $y = $x.sha1('K24');
        // $z = base64_encode($y);
        try {
            $x = base64_encode($ordercode . ';'. $outlet_id . ';' . $user . ';' . $jenis . ';' . VFormatter::getKodeVerifikasi($ordercode));
            $y = $x.sha1('K24');
            $z = base64_encode($y);

            return $z;    
        } catch (Exception $e) {
            return null;
        }
    }

    public static function decryptBatalKirim($string){
        try {
            $first = base64_decode($string);
            $second = explode(sha1('K24'),$first);
            $data = base64_decode($second[0]);    

            $data = explode(';', $data);
            if($data != null){
                return $data;    
            }else{
                return null;
            }

            
        } catch (Exception $e) {
            return null;
        }
    }

    public static function DokuResponseCode($string){
        $list = array(
            null => "Not Defined Error",
            "0000" => "Successful approval/Completion",
            "0001" => "Refer to card issuer",
            "0002" => "Refer to card issuer, special condition",
            "0003" => "Invalid merchant or service provider",
            "0004" => "Pickup card",
            "0005" => "Do Not Honor",
            "0006" => "Error",
            "0007" => "Pickup card, special condition (other than lost/stolen card)",
            "0008" => "Honor with ID",
            "0010" => "Partial Approval - Private label",
            "0011" => "VIP approval",
            "0012" => "Invalid Transaction",
            "0013" => "Invalid amount (currency conversion field overflow. Visa Cash - Invalid load mount)",
            "0014" => "Invalid account number (no such number)",
            "0015" => "No such issuer",
            "0019" => "Re-enter transaction",
            "0021" => "No Action taken (unable to bacck out prior transaction)",
            "0025" => "Unable to locate record in file, or account number is missing from inquiry",
            "0028" => "File is temporarely unavailable",
            "0030" => "Format error",
            "0041" => "Pickup card (lost card)",
            "0043" => "Pickup card (stolen card)",
            "0051" => "Insufficient funds",
            "0052" => "No checking account",
            "0053" => "non savings account",
            "0054" => "Expired card",
            "0055" => "Incorrect PIN (Visa cash - invalid or missing signature)",
            "0057" => "Transaction not permitted to cardholder (Visa cash - incorrect routing, not a load request)",
            "0058" => "Transaction not allowed at terminal",
            "0061" => "Activity amount limit exceeded",
            "0062" => "Restricted card (for example in country exclusion table)",
            "0063" => "Security violation",
            "0065" => "Activity count limit exceeded",
            "0075" => "Allowable number of PIN-entry tries exceeded",
            "0076" => "Unable to locate previous message (no match on Retrieval Reference number)",
            "0077" => "Previous message located for a repeat or reversal, but repeat or reversal data are inconsistent with original message",
            "0078" => "Invalid/nonexistent account specified (general)",
            "0080" => "Invalid date (For use in private label card transactions and check acceptance transactions)",
            "0081" => "PIN Cryptographic error found (error found by VIC security module during PIN decryption)",
            "0082" => "Incorrect CW/1CW",
            "0083" => "Unable to verify PIN",
            "0084" => "Invalid Authorization Life Cycle",
            "0085" => "No reason to decline a request for account number verification or address verification",
            "0091" => "Issuer unavailable or switch inoperative (STIP not applicable or available for this transaction)",
            "0092" => "Destination cannot be found for routing",
            "0093" => "Transactioncannot be completed violation of law",
            "0094" => "Duplicate transmission detected",
            "0096" => "System malfunction / System malfunction or certain field error conditions",
            "0099" => "BIN Blocking / IP Blocking / Not registered Mandiri Clickpay",
            "00TO" => "Transaction timeout",
            "00BB" => "Bin Blockiing",
            "00IP" => "IP Blocking",
            "00CB" => "CC Blocking",
            "003D" => "3DS Auth Problem",
            "00DI" => "Duplicate Invoice",
            "00FN" => "Notify Failed",
            "00FV" => "Verifed Failed",
            "00IF" => "Insuficient Param",
            "00BA" => "Blocking Bin By Acquirer",
            "00SM" => "Store Maxmind Failed",
            "00BL" => "Batch Have Over Limit Transaction",
            "00DB" => "Duplicate Batch",
            "00IW" => "Invalid Words",
            "00FP" => "Failed Executing Pre Payment Plugin",
            "00MD" => "MIP Request Denied",
            "00FC" => "Card pattern validation failed",
            "00TD" => "Transaction disabled",
            "00SF" => "SmartSpending transaction fail",
            "00DW" => "The merchant do not have hash password",
            "5501" => "Payment channel not registered", 
            "5502" => "Merchant is disabled", 
            "5503" => "Maximum attempt 3 times", 
            "5504" => "Words not match", 
            "5505" => "Invalid parameter",
            "5506" => "Notify failed", 
            "5507" => "Invalid parameter detected / Customer click cancel process", 
            "5508" => "Re-enter transaction", 
            "5509" => "Payment code already expired",
            "5510" => "Cancel by Customer",
            "5511" => "Not an error, payment code has not been paid by Customer", 
            );

        if (array_key_exists($string, $list)) {
            return $list[$string];
        } else {
            return "(" . $string . ")";
        }
    }

    public function getProductImageFileName($id)
    {
        $productImageFileName = "SELECT `image` FROM `product` WHERE `id` = $id";
        return $productImageFileName;
    }

    public function getProductImageURL($id)
    {
        $productImageURL = IMAGE_SERVER.'/product/'.getProductImageFileName($id);
        return $productImageURL;
    }

    public function getNoImageURL()
    {
        $noImageURL = IMAGE_SERVER.'/product/noimage.png';
        return $noImageURL;
    }

    public static function getShippingMethod($text){
        if($text == "UNDER ONE HOUR") return "OHD";
        if($text == "LANGSUNG") return "ODD";
        if($text == "PAKET") return "PAKET";
        if($text == "AMBIL DI APOTEK") return "AMBIL DI APOTEK";
        return "UNDEFINED";
    }

    public static function getShipper(){
        $sql = "SHOW COLUMNS FROM cart_detail WHERE Field = 'shipper'";
        $data = Yii::app()->db->createCommand($sql)->queryAll(); 
        $type = $data[0]['Type'];
        $type = str_replace("enum(", "", $type);
        $type = str_replace(")", "", $type);
        $type = str_replace("'", "", $type);
        $type = explode(",", $type);
        return $type;
    }

    public static function getPaymentMethod($text){
        if($text == "SGO") return "BCA Klikpay / Mandiri Supply Chain";
        if($text == "DOKU") return "Doku Wallet";
        if($text == "COD") return "Bayar di tempat";
        if($text == "BANK TRANSFER") return "BANK Transfer";
        if($text == "KARTU KREDIT") return "Kartu Kredit";
        if($text == "OCBC") return "Promo OCBC";
        if($text == "ATM BERSAMA") return "ATM Bersama";
        if($text == "FASAPAY") return "Fasapay";
        if($text == "MANDIRI CLICKPAY") return "Mandiri Clickpay";
        if($text == "BNI DEBIT ONLINE") return "BNI Debit Online";
        if($text == "DANAMON") return "Danamon";
        if($text == "MUAMALAT") return "Muamalat";
        if($text == "BUKOPIN") return "Bukopin";
        if($text == "MAYBANK") return "Maybank";
        if($text == "PROMO UOB") return "PROMO UOB";
        if($text == "PERMATANET") return "PermataNet";
        if($text == "MSAKU") return "M-Saku";
        if($text == "PROMO BNI") return "PROMO BNI";
        if($text == "BEBASBAYAR") return "BEBASBAYAR";
        if($text == "FASPAY_BRI") return "FASPAY_BRI";
        if($text == "CIMB CLICK") return "CIMB CLICKS";
        if($text == "VA BCA") return "BCA VIRTUAL ACCOUNT";
        if($text == Constant::PAYMENT_VA_BNI) return "BNI VIRTUAL ACCOUNT";
        if($text == Constant::PAYMENT_VA_MANDIRI) return "MANDIRI VIRTUAL ACCOUNT";
        return "UNDEFINED";
    }

    public static function verifyReportHC($id){
        $id = base64_decode($id);
        if($id == 'P4sT1p3DuL!'){
            return true; 
        }
        return false;
    }

    public static function verifyReportHCLogin($id, $password){
        if($id == "cucumber.daily.report" && $password == 'P4sT1p3DuL!'){
            return true; 
        }
        return false;
    }

    private static function closingSQL(){
        return "
        SELECT (case 
                    when cast(hp.waktu as time) BETWEEN '00:00:00' AND '07:44:59' then 0
                    when cast(hp.waktu as time) BETWEEN '07:45:00' AND '14:59:59' then 1
                    when cast(hp.waktu as time) BETWEEN '15:00:00' AND '21:44:59' then 2
                    else 3 end) as 'shift', 
            cd.name as 'nama', cd.order_code as 'kode_order',
            if(cd.shipping_method = 'UNDER ONE HOUR',cd.total_price,'') as 'OHD', 
            if(cd.shipping_method = 'LANGSUNG',cd.total_price,'') as 'ODD', 
            if(cd.shipping_method = 'PAKET',cd.total_price,'') as 'PAKET', 
            if(cd.shipping_method = 'AMBIL DI APOTEK',cd.total_price,'') as 'APOTEK', 
            p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', cd.flag as 'status_report', cd.user_id as 'id_user', cast(hp.waktu as date) tanggal, cast(hp.waktu as time) jam
        FROM cart_detail as cd 
        INNER JOIN province as p ON p.id = cd.province_id
        INNER JOIN (select max(hp0.id), hp0.order_code, max(concat(hp0.tanggal,' ',hp0.jam)) waktu
                    from history_penanganan hp0
                    join cart_detail cd0 on hp0.order_code = cd0.order_code
                    where cd0.shipping_method is not null
                        and ((cd0.payment_method = 'COD' AND hp0.status_id = 7) 
                            OR (cd0.payment_method NOT IN ('COD','BANK TRANSFER') AND hp0.status_id = 3)
                            OR (cd0.payment_method = 'BANK TRANSFER' AND hp0.status_id = 20 AND hp0.keterangan like '%Sudah dikonfirmasi. Catatan:%'))
                        and hp0.order_code not in (SELECT DISTINCT HP.order_code 
                                                   FROM history_penanganan as HP 
                                                   WHERE status_id in (8,9,10,11) ) 
                    group by hp0.order_code) as hp ON hp.order_code = cd.order_code
        ORDER BY shift desc, cd.shipping_method
        ";
    }

    private static function closingSQL_real(){
        //10 - refund
        return "
        SELECT (case 
                when cast(hp.waktu as time) BETWEEN '00:00:00' AND '07:44:59' then 0
                when cast(hp.waktu as time) BETWEEN '07:45:00' AND '14:59:59' then 1
                when cast(hp.waktu as time) BETWEEN '15:00:00' AND '21:44:59' then 2
            else 3 end) as 'shift', 
            cd.name as 'nama', cd.order_code as 'kode_order',
            if(cd.shipping_method = 'UNDER ONE HOUR',
                COALESCE(((cd.total_price - RIGHT(total_price, 2)) - COALESCE(cd.shipping_costs, 0) - COALESCE(cd.biaya_admin, 0) - COALESCE(cd.packing_kayu, 0) - COALESCE(cd.bubble_wrap, 0)), 0) + (COALESCE(cr.nominal, 0) - RIGHT(COALESCE(cr.nominal, 0), 2)),'') as 'OHD', 
            if(cd.shipping_method = 'LANGSUNG',
                COALESCE(((cd.total_price - RIGHT(total_price, 2)) - COALESCE(cd.shipping_costs, 0) - COALESCE(cd.biaya_admin, 0) - COALESCE(cd.packing_kayu, 0) - COALESCE(cd.bubble_wrap, 0)), 0) + (COALESCE(cr.nominal, 0) - RIGHT(COALESCE(cr.nominal, 0), 2)),'') as 'ODD', 
            if(cd.shipping_method = 'PAKET',
                COALESCE(((cd.total_price - RIGHT(total_price, 2)) - COALESCE(cd.shipping_costs, 0) - COALESCE(cd.biaya_admin, 0) - COALESCE(cd.packing_kayu, 0) - COALESCE(cd.bubble_wrap, 0)), 0) + (COALESCE(cr.nominal, 0) - RIGHT(COALESCE(cr.nominal, 0), 2)),'') as 'PAKET', 
            if(cd.shipping_method = 'AMBIL DI APOTEK',
                COALESCE(((cd.total_price - RIGHT(total_price, 2)) - COALESCE(cd.shipping_costs, 0) - COALESCE(cd.biaya_admin, 0) - COALESCE(cd.packing_kayu, 0) - COALESCE(cd.bubble_wrap, 0)), 0) + (COALESCE(cr.nominal, 0) - RIGHT(COALESCE(cr.nominal, 0), 2)),'') as 'APOTEK', 
            p.name as 'wilayah', 
            cd.source as 'keterangan', 
            cd.payment_method as 'pembayaran', 
            cd.flag as 'status_report',
            cd.user_id as 'id_user',
            cast(hp.waktu as date) tanggal, 
            cast(hp.waktu as time) jam
        FROM cart_detail as cd 
        INNER JOIN province as p ON p.id = cd.province_id
        INNER JOIN (
            select max(hp0.id), 
            hp0.order_code, 
            max(concat(hp0.tanggal,' ',hp0.jam)) waktu
            from history_penanganan hp0
            join cart_detail cd0 on hp0.order_code = cd0.order_code
            where cd0.shipping_method is not null
            and ((cd0.payment_method IN ('COD', 'GOODDOCTOR') AND hp0.status_id = 7) 
                OR (cd0.payment_method NOT IN ('COD','BANK TRANSFER') AND hp0.status_id = 3)
                OR (cd0.payment_method = 'BANK TRANSFER' 
                AND hp0.status_id = 20 
                AND hp0.keterangan like '%Sudah dikonfirmasi. Catatan:%'))
            and hp0.order_code not in (
                SELECT DISTINCT HP.order_code 
                FROM history_penanganan as HP 
                WHERE status_id in (8,9,11) )  
            group by hp0.order_code) 
            as hp ON hp.order_code = cd.order_code
        LEFT JOIN cart_voucher cr ON cr.cart_detail_id = cd.id
        ORDER BY shift desc, cd.shipping_method
        ";
    }

    public static function closingSQL_refund($startDate=null, $endDate=null){
        $dateCondition = "DATE(cdr.refunded_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        if (isset($startDate) && isset($endDate))
            $dateCondition = "(DATE(cdr.refunded_date) BETWEEN ('" . $startDate . "') AND ('" . $endDate . "'))";

        return "
            SELECT  cd.id,
                    cd.order_code,
                    cd.name,
                    cdr.created_date,
                    cdr.refunded_date,
                    concat(cdr.type, '-', cdr.type_2) as 'refund_type',
                    (COALESCE(sisa_dana,0) + COALESCE(kembalian_point,0) - 
                        (CASE WHEN cdr.type_2 = 'seluruh' THEN COALESCE(cd.shipping_costs,0) ELSE 0 END)) as 'total_refund',
                    cdr.cart_detail_id
            FROM cart_detail_refund as cdr
                INNER JOIN 
                    (SELECT id, order_code, user_id, name, shipping_costs, (COALESCE(total_price, 0) - COALESCE(shipping_costs, 0)) AS total_tanpa_shipping FROM cart_detail) 
                AS cd ON cd.id = cdr.cart_detail_id
            LEFT JOIN laporan_closing lc ON cd.order_code = lc.kode_order AND lc.shift IS NULL AND COALESCE(lc.total_refund, 0) >= cd.total_tanpa_shipping 
            WHERE ".$dateCondition." AND cdr.flag <> 1 AND cd.user_id <> 4
        ";
    }
    public static function dailyDetailReportSQLRefund($shift, $data = null, $startDate= null, $endDate = null){
        /*status_report:
        0 = belum pernah action report
        1 = sudah pernah action report
        */

        if($data == "real")
            $sqlView = self::closingSQL_real();
        else
            $sqlView = self::closingSQL();

        $dateCondition = "V.tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        if (isset($startDate) && isset($endDate))
            $dateCondition = "V.tanggal BETWEEN ('" . $startDate . "') AND ('" . $endDate . "')";
    
        if($shift == 1){
            return "SELECT * FROM (".$sqlView.") as V 
                WHERE " . $dateCondition . " 
                AND V.shift = 1 AND V.status_report <> 1 AND id_user <> 4";
        }else if($shift == 2){
            return "SELECT * FROM (".$sqlView.") as V 
                WHERE " . $dateCondition . " 
                AND V.shift = 2 AND V.status_report <> 1 AND id_user <> 4";
        }else if($shift == 3){
            return "SELECT * FROM (".$sqlView.") as V 
                WHERE V.status_report <> 1 AND id_user <> 4 AND (" . $dateCondition . " AND V.shift = 3)
                OR (V.tanggal = date(CURRENT_DATE) AND V.shift = 0)";
        }else if($shift == null){
            return "SELECT * FROM (".$sqlView.") as V 
                WHERE " . $dateCondition ." AND V.status_report <> 1 AND id_user <> 4";
        }
        
    }

    public static function dailyDetailReportGoodDoctor($startDate= null, $endDate = null){

        $dateCondition = "V.tanggal = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
        if (isset($startDate) && isset($endDate))
            $dateCondition = "V.tanggal BETWEEN ('" . $startDate . "') AND ('" . $endDate . "')";
        
        $sql = "SELECT * FROM (SELECT cd.order_code, cd.name, date(cd.`date`) as tanggal, sum(cd.`total_price`) as omset FROM cart_detail_gooddoctor cdg LEFT JOIN cart_detail cd ON cd.id=cdg.cart_detail_id WHERE cd.`cart_status_id` IN (19,3,16,12,8,9,4) AND cdg.`cart_detail_id` IS NOT NULL AND cd.flag <> 1 AND cd.user_id <> 4 GROUP By cd.id ORDER By date(cd.`date`) ASC) as V WHERE (".$dateCondition.")";

        return $sql;
    }

    private static function closingSQL_old(){
        return "
            SELECT 0 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', cd.total_price as 'OHD', '' as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'UNDER ONE HOUR' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '00:00:00' AND '07:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL 

            SELECT 0 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', cd.total_price as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'LANGSUNG' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '00:00:00' AND '07:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 0 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', cd.total_price as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'PAKET' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '00:00:00' AND '07:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 0 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', '' as 'PAKET', cd.total_price as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'AMBIL DI APOTEK' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '00:00:00' AND '07:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 1 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', cd.total_price as 'OHD', '' as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'UNDER ONE HOUR' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '07:45:00' AND '14:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL 

            SELECT 1 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', cd.total_price as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'LANGSUNG' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '07:45:00' AND '14:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 1 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', cd.total_price as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'PAKET' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '07:45:00' AND '14:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 1 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', '' as 'PAKET', cd.total_price as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'AMBIL DI APOTEK' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '07:45:00' AND '14:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 2 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', cd.total_price as 'OHD', '' as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'UNDER ONE HOUR' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '15:00:00' AND '21:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL 

            SELECT 2 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', cd.total_price as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'LANGSUNG' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '15:00:00' AND '21:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 2 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', cd.total_price as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'PAKET' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '15:00:00' AND '21:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 2 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', '' as 'PAKET', cd.total_price as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'AMBIL DI APOTEK' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '15:00:00' AND '21:44:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 3 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', cd.total_price as 'OHD', '' as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'UNDER ONE HOUR' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '21:45:00' AND '23:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL 

            SELECT 3 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', cd.total_price as 'ODD', '' as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'LANGSUNG' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '21:45:00' AND '23:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 3 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', cd.total_price as 'PAKET', '' as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'PAKET' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '21:45:00' AND '23:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code

            UNION ALL

            SELECT 3 as 'shift', cd.name as 'nama', cd.order_code as 'kode_order', '' as 'OHD', '' as 'ODD', '' as 'PAKET', cd.total_price as 'APOTEK', p.name as 'wilayah', cd.source as 'keterangan', cd.payment_method as 'pembayaran', hp.tanggal, hp.jam FROM cart_detail as cd inner join province as p on p.id = cd.province_id inner join (
                select max(history_penanganan.id), history_penanganan.order_code, history_penanganan.tanggal, history_penanganan.jam, history_penanganan.status_id, history_penanganan.user_id, history_penanganan.keterangan  
            from history_penanganan 
            join cart_detail
            on history_penanganan.order_code = cart_detail.order_code
            WHERE shipping_method = 'AMBIL DI APOTEK' 
            AND ((payment_method = 'COD' AND history_penanganan.status_id = 7) OR (payment_method != 'COD' AND history_penanganan.status_id = 3))
            AND history_penanganan.jam BETWEEN '21:45:00' AND '23:59:59'
            AND history_penanganan.order_code NOT IN (SELECT DISTINCT HP.order_code FROM history_penanganan as HP WHERE status_id = 8 || status_id = 9 || status_id = 10 || status_id = 11 ) 
            group by history_penanganan.order_code) as hp on hp.order_code = cd.order_code
        ";
    }

    public static function dailyDetailReportSQL($shift, $data = null){
        if($data == "old")
            $sqlView = self::closingSQL_old();
        else
            $sqlView = self::closingSQL();
        if($shift == 1){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = DATE_SUB(date(CURRENT_DATE), INTERVAL 1 DAY) AND 
                V.shift = 1 ";
        }else if($shift == 2){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = DATE_SUB(date(CURRENT_DATE), INTERVAL 1 DAY) AND 
                V.shift = 2 ";
        }else if($shift == 3){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = DATE_SUB(date(CURRENT_DATE), INTERVAL 1 DAY) AND 
                V.shift = 3 OR V.tanggal = date(CURRENT_DATE) AND V.shift = 0 ";
        }
        
    }

    public static function shiftDetailReportSQL($shift){
        $sqlView = self::closingSQL();
        if($shift == 1){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = date(CURRENT_DATE) AND 
                V.shift = 1 ";
        }else if($shift == 2){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = date(CURRENT_DATE) AND 
                V.shift = 2 ";
        }else if($shift == 3){
            return "SELECT * FROM (".$sqlView.") as V where 
                V.tanggal = DATE_SUB(date(CURRENT_DATE), INTERVAL 1 DAY) AND 
                V.shift = 3 OR V.tanggal = date(CURRENT_DATE) AND V.shift = 0 ";
        }
        
    }

    public static function dailyReportSQL(){
        return "(
                SELECT 
                '07.30 - 15.00' as Jam,
                1 as Shift, 
                IFNULL(shipTotal('UNDER ONE HOUR', 1, date(CURRENT_DATE)), 0) as OHD,
                IFNULL(shipTotal('LANGSUNG', 1, date(CURRENT_DATE)), 0) as ODD,
                IFNULL(shipTotal('PAKET', 1, date(CURRENT_DATE)), 0) as PAKET,
                IFNULL(shipTotal('AMBIL DI APOTEK', 1, date(CURRENT_DATE)), 0) as APOTEK, 
                IFNULL(shipTotal('UNDER ONE HOUR', 1, date(CURRENT_DATE)), 0) + 
                IFNULL(shipTotal('LANGSUNG', 1, date(CURRENT_DATE)), 0)  + 
                IFNULL(shipTotal('PAKET', 1, date(CURRENT_DATE)), 0) + IFNULL(shipTotal('AMBIL DI APOTEK', 1, date(CURRENT_DATE)), 0) as SUBTOTAL
                )
                UNION 
                (
                SELECT 
                '15.00 - 21.45' as Jam,
                2 as Shift, 
                IFNULL(shipTotal('UNDER ONE HOUR', 2, date(CURRENT_DATE)), 0) as OHD,
                IFNULL(shipTotal('LANGSUNG', 2, date(CURRENT_DATE)), 0) as ODD,
                IFNULL(shipTotal('PAKET', 2, date(CURRENT_DATE)), 0) as PAKET,
                IFNULL(shipTotal('AMBIL DI APOTEK', 2, date(CURRENT_DATE)), 0) as APOTEK, 
                IFNULL(shipTotal('UNDER ONE HOUR', 2, date(CURRENT_DATE)), 0) + 
                IFNULL(shipTotal('LANGSUNG', 2, date(CURRENT_DATE)), 0)  + 
                IFNULL(shipTotal('PAKET', 2, date(CURRENT_DATE)), 0) + IFNULL(shipTotal('AMBIL DI APOTEK', 2, date(CURRENT_DATE)), 0) as SUBTOTAL
                )
                UNION
                (
                SELECT 
                '21.45 - 07.30' as Jam,
                3 as Shift, 
                IFNULL(shipTotal('UNDER ONE HOUR', 3, date(CURRENT_DATE)), 0) as OHD,
                IFNULL(shipTotal('LANGSUNG', 3, date(CURRENT_DATE)), 0) as ODD,
                IFNULL(shipTotal('PAKET', 3, date(CURRENT_DATE)), 0) as PAKET,
                IFNULL(shipTotal('AMBIL DI APOTEK', 3, date(CURRENT_DATE)), 0) as APOTEK, 
                IFNULL(shipTotal('UNDER ONE HOUR', 3, date(CURRENT_DATE)), 0) + 
                IFNULL(shipTotal('LANGSUNG', 3, date(CURRENT_DATE)), 0)  + 
                IFNULL(shipTotal('PAKET', 3, date(CURRENT_DATE)), 0) + 
                IFNULL(shipTotal('AMBIL DI APOTEK', 2, date(CURRENT_DATE)), 0)  SUBTOTAL
                )";
    }

    public static function dailyHistoryKeyword(){
        try{
        $sqlVal = EnvironmentVariable::model()->find("name = 'HISTORY_KEYWORD_ENDDATE'");
        $enddate = date('Y-m-d');
        if(isset($sqlVal)){
            $getVal = EnvironmentVariable::model()->find("name = 'HISTORY_KEYWORD_ENDDATE'")->value;
        }else{
            $getVal = 0;
        }
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$getVal)) {
            $enddate = $getVal;
        } 

        $startdate = date('Y-m-d',strtotime('-30 days',strtotime($enddate)));

        $dateCondition = "date(date_act) BETWEEN ('" . $startdate . "') AND ('" . $enddate . "')";

        return "
        SELECT keyword, count(keyword) as jml, max(date_act) as last_date FROM log_keyword WHERE ".$dateCondition." GROUP BY keyword";

        } catch (Exception $e) {
            return null;
        }
    }

    public static function dailyGoodDoctor(){
        try{
            $day = intval(EnvironmentVariable::getValue('GOODDOCTOR_DAILY_REPORT', 31));
            // DAYNAME(date(cd.date)) as hari,
            // return "SELECT date(cd.`date`) as tanggal, sum(cd.`total_price`) as omset, count(cd.`id`) as invoice, round(sum(cd.`total_price`)/count(cd.`id`)) as acb FROM cart_detail_gooddoctor cdg LEFT JOIN cart_detail cd ON cd.id=cdg.cart_detail_id WHERE date(cd.`date`) >= DATE_SUB(CURDATE(), INTERVAL ".intval($day)." DAY) AND cd.`cart_status_id` IN (19,3,16,12,8,9,4) AND cdg.`cart_detail_id` IS NOT NULL GROUP By date(cd.`date`) ORDER By date(cd.`date`) ASC";

            // source dari laporan closing per sprint 119
            return "SELECT tgl_omset_masuk as tanggal, sum(ohd) as omset, count(lc.id) as invoice,
                    round(sum(ohd)/count(lc.id)) as acb 
                    FROM laporan_closing lc
                    LEFT OUTER JOIN cart_detail cd ON cd.order_code = lc.kode_order
                    WHERE tgl_omset_masuk >= DATE_SUB(CURDATE(), INTERVAL $day DAY)
                    AND (lc.keterangan = 'GOODDOCTOR' OR lc.pembayaran = 'GOODDOCTOR')
                    AND cd.user_id NOT IN (4,1229)
                    AND cd.cart_status_id NOT IN (5,11,21,18,28,10)
                    GROUP BY tgl_omset_masuk
                    ORDER BY tgl_omset_masuk";
        } catch (Exception $e) {
            return null;
        }
    }

    public static function weeklyReportSQL(){
        $tgl = date("Y-m-d");
        return "select IFNULL(shipTotalWeek('UNDER ONE HOUR', '".$tgl."'),0) as OHD, IFNULL(shipTotalWeek('LANGSUNG', '".$tgl."'),0) as ODD, IFNULL(shipTotalWeek('PAKET', '".$tgl."'),0) as PAKET, IFNULL(shipTotalWeek('AMBIL DI APOTEK', '".$tgl."'),0) as APOTEK";
    }

    public static function monthlyReportSQL(){
        $startdate = date("Y-m-01", strtotime("-1 months"));;
        $enddate = date('Y-m-t',strtotime($startdate));
        return "select IFNULL(shipTotalMonth('UNDER ONE HOUR', '".$startdate."', '".$enddate."'),0) as OHD, IFNULL(shipTotalMonth('LANGSUNG', '".$startdate."', '".$enddate."'),0) as ODD, IFNULL(shipTotalMonth('PAKET', '".$startdate."', '".$enddate."'),0) as PAKET, IFNULL(shipTotalMonth('AMBIL DI APOTEK', '".$startdate."', '".$enddate."'),0) as APOTEK";
    }

    public static function countPromoItemUserDay($id_promo, $id_user){
        // brp user yang menggunakan promo item pada HARI ini
        $result = array();
        date_default_timezone_set("Asia/Jakarta");
        $date = Date('Y-m-d');

        $sql = "SELECT COUNT( DISTINCT user_id ) FROM `cart_detail` INNER JOIN cart ON cart.cart_detail_id = cart_detail.id  WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(date) = '".$date."' AND cart.id_limit = ".$id_promo;
        $result['sum'] = Yii::app()->db->createCommand($sql)->queryScalar();
        $result['exist'] = false;

        if(isset($id_user)){
            $sql2 = "SELECT COUNT(*) FROM `cart_detail` INNER JOIN cart ON cart.cart_detail_id = cart_detail.id  WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(date) = '".$date."' AND cart.id_limit = ".$id_promo . " AND cart_detail.user_id = ". $id_user;

            $c = Yii::app()->db->createCommand($sql2)->queryScalar();
            if($c > 0)
                $result['exist'] = true;
        }

        return $result;
    }

    public static function countPromoItemProductDay($id_promo, $id_user){
        // brp product yang dibeli user dengan menggunakan promo item pada HARI ini
        $result = array();
        date_default_timezone_set("Asia/Jakarta");
        $date = Date('Y-m-d');
        $sql = "SELECT SUM(cart.qty) as Jumlah FROM cart_detail INNER JOIN cart ON cart.cart_detail_id = cart_detail.id WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(cart_detail.date) = '".$date."' AND cart.id_limit = ".$id_promo . " AND cart_detail.user_id  = ". $id_user;
        $result['sum'] = Yii::app()->db->createCommand($sql)->queryScalar();
        return $result;
    }

    public static function countPromoItemUserPeriode($id_promo, $id_user){
        // brp user yang menggunakan promo item pada PERIODE PROMO
        $result = array();

        $promo = ProductPromo::model()->findByPk($id_promo);
            if(isset($promo)){
                date_default_timezone_set("Asia/Jakarta");
                $date = Date('Y-m-d');
                $sql = "SELECT COUNT( DISTINCT user_id ) FROM `cart_detail` INNER JOIN cart ON cart.cart_detail_id = cart_detail.id  WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(cart_detail.date) >= Date('".$promo->promotion_start_date."') AND Date(cart_detail.date) <= Date('".$promo->promotion_end_date."') AND cart.id_limit = ".$id_promo;
                $result['sum'] = Yii::app()->db->createCommand($sql)->queryScalar();
                $result['exist'] = false;
                
                if(isset($id_user)){
                    $sql2 = "SELECT COUNT(*) FROM `cart_detail` INNER JOIN cart ON cart.cart_detail_id = cart_detail.id  WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(cart_detail.date) >= Date('".$promo->promotion_start_date."') AND Date(cart_detail.date) <= Date('".$promo->promotion_end_date."') AND cart.id_limit = ".$id_promo . " AND cart_detail.user_id = ". $id_user;;
                    $c = Yii::app()->db->createCommand($sql2)->queryScalar();
                    if($c > 0)
                        $result['exist'] = true;
                }

        }
        return $result;
    }

    public static function countPromoItemProductPeriode($id_promo, $id_user){
        // brp product yang dibeli user dengan menggunakan promo item pada PERIODE PROMO
        $result = null;
        $promo = ProductPromo::model()->findByPk($id_promo);
            if(isset($promo)){
                date_default_timezone_set("Asia/Jakarta");
                $date = Date('Y-m-d');
                $sql = "SELECT SUM(cart.qty) as Jumlah FROM cart_detail INNER JOIN cart ON cart.cart_detail_id = cart_detail.id WHERE cart_detail.cart_status_id in (1, 2, 3, 4, 8, 9, 12, 19) AND Date(cart_detail.date) >= Date('".$promo->promotion_start_date."') AND Date(cart_detail.date) <= Date('".$promo->promotion_end_date."') AND cart.id_limit = ".$id_promo . " AND cart_detail.user_id  = ". $id_user;
                $result['sum'] = Yii::app()->db->createCommand($sql)->queryScalar();
                return $result;       
        }   
        return $result;
    }    

    public static function checkPromoItem($id_product){

        /*
            status | promo | limit | available
             0     | Tidak |  *    | *
             1     | Ada   |  Ada  | Ya
             2     | Ada   |  Ada  | Tidak
             3     | Ada   |  Tidak| *

        */

        date_default_timezone_set("Asia/Jakarta");
        $today = "'".date("Y-m-d")."'";
        $today_time = "'".date("H:i:s")."'";
        $result = array();
        $result['status'] = 0;

        $promo = ProductPromo::model()->find("product_id = '$id_product' and ( DATEDIFF(".$today.",promotion_start_date) > -1 OR promotion_start_date IS NULL) and DATEDIFF(promotion_end_date,".$today.") > -1  and (".$today_time." > start_hour && ".$today_time." < end_hour OR start_hour IS NULL OR end_hour IS NULL)");


        $id_user = null;

        if(Yii::app()->user->id){
            $id_user = Yii::app()->user->id;
        }

        



        if(isset($promo)){
            $result['status'] = 3;
            if($id_user == null){
                /*
                    cek batas promo dulu. 
                    kalau masih ada sisa quota user per periode atau per hari, 
                */
                if($promo->limit_status){
                    if($promo->limit_duration == "hari"){
                        $dataUserDay = self::countPromoItemUserDay($promo->id, null);
                        $userDay = $dataUserDay['sum'];
                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{
                                $result['status'] = 2;
                            }    
                        }else{
                            $result['status'] = 1;
                            $result['unit_price_before'] = $promo->price_before_diskon;
                            $result['unit_price_after'] = $promo->price_after_diskon;
                            if($promo->limit_qty == null)
                                $result['qty'] = 100;
                            else
                                $result['qty'] = $promo->limit_qty;
                        }
                        
                    }else if($promo->limit_duration == "periode"){
                        $dataUserPeriode = self::countPromoItemUserPeriode($promo->id, null);
                        $userPeriode = $dataUserPeriode['sum'];
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{
                                $result['status'] = 2;
                            }    
                        }else{
                            $result['status'] = 1;
                            $result['unit_price_before'] = $promo->price_before_diskon;
                            $result['unit_price_after'] = $promo->price_after_diskon;
                            if($promo->limit_qty == null)
                                $result['qty'] = 100;
                            else
                                $result['qty'] = $promo->limit_qty;
                        }
                        
                    }
                }
                return $result;
            }
            if($promo->limit_status){
                $result['status'] = 2;

                if($promo->limit_duration == "hari"){
                    
                    $dataUserDay = self::countPromoItemUserDay($promo->id, $id_user);
                    //$modelCD = CartDetail::model()->find('user_id = '.$id_user .' AND id_promo_item = '. $promo->id);
                    $userDay = $dataUserDay['sum'];
                    $exist = false;
                    if(isset($dataUserDay['exist'])){
                        $exist = $dataUserDay['exist'];
                    }

                    if($promo->limit_priority == "user"){
                        // cek kalau hari ini sudah lebih dari batas user yang dapat promo, cancel promo

                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;

                            } 

                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;    
                            }
                            
                        }
                        

                    }else if($promo->limit_priority == "product"){
                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user && !$exist ){
                                // BISA PROMO

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else if($userDay < $promo->limit_user && $exist){
                                
                                $productDay = self::countPromoItemProductDay($promo->id, $id_user);
                                
                                if(!isset($productDay))
                                    $productDay=0;
                                else
                                    $productDay=$productDay['sum'];
                                
                                if($promo->limit_qty != null){
                                    if($promo->limit_qty - $productDay > 0){
                                        $result['status'] = 1;
                                        $result['unit_price_before'] = $promo->price_before_diskon;
                                        $result['unit_price_after'] = $promo->price_after_diskon;
                                        
                                        if($promo->limit_qty == null)
                                            $result['qty'] = 100;
                                        else
                                            $result['qty'] = $promo->limit_qty - $productDay;    
                                    }else{
                                        $result['status'] = 2;
                                    }    
                                }else{
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else
                                        $result['qty'] = $promo->limit_qty - $productDay;    
                                }
                                
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{

                                $productDay = self::countPromoItemProductDay($promo->id, $id_user);

                                if(!isset($productDay))
                                    $productDay=0;
                                else
                                    $productDay=$productDay['sum'];

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                
                                if($promo->limit_qty - $productDay > 0){
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else
                                        $result['qty'] = $promo->limit_qty - $productDay;    
                                }else{
                                    $result['status'] = 2;
                                } 
                            }
                        }
                        
                    }
                }else if($promo->limit_duration == "periode"){ 

                    $dataUserPeriode = self::countPromoItemUserPeriode($promo->id, $id_user);
                    $userPeriode = $dataUserPeriode['sum'];
                    $exist = false;
                    if(isset($dataUserPeriode['exist'])){
                        $exist = $dataUserPeriode['exist'];
                    }
                    if($promo->limit_priority == "user"){
                        // cek kalau hari ini sudah lebih dari batas user yang dapat promo, cancel promo
                        
                        
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;    
                            }
                            
                        }
                        

                    }else if($promo->limit_priority == "product"){
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else if($userPeriode < $promo->limit_user && $exist){
                                $productPeriode = self::countPromoItemProductPeriode($promo->id, $id_user);
                                if(!isset($productPeriode))
                                    $productPeriode=0;
                                else
                                    $productPeriode=$productPeriode['sum'];


                                if($promo->limit_qty != null){
                                    if($promo->limit_qty - $productPeriode > 0){
                                        $result['status'] = 1;
                                        $result['unit_price_before'] = $promo->price_before_diskon;
                                        $result['unit_price_after'] = $promo->price_after_diskon;
                                        if($promo->limit_qty == null)
                                            $result['qty'] = 100;
                                        else                                    
                                            $result['qty'] = $promo->limit_qty - $productPeriode;
                                    }else{
                                        $result['status'] = 2;
                                    }
                                }else{
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else                                    
                                        $result['qty'] = $promo->limit_qty - $productPeriode;
                                }
                                
                                
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{

                                $productPeriode = self::countPromoItemProductPeriode($promo->id, $id_user);
                                if(!isset($productPeriode))
                                    $productPeriode=0;
                                else
                                    $productPeriode=$productPeriode['sum'];

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                
                                if($promo->limit_qty - $productPeriode > 0){
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else                                    
                                        $result['qty'] = $promo->limit_qty - $productPeriode;
                                }else{
                                    $result['status'] = 2;
                                }
                            }
                        }
                        
                    }
                }

            }else{
                $result['status'] = 3;
            }
        }

        return $result;

    }

    public static function checkPromoItemAdmin($id_product, $id_user){

        /*
            status | promo | limit | available
             0     | Tidak |  *    | *
             1     | Ada   |  Ada  | Ya
             2     | Ada   |  Ada  | Tidak
             3     | Ada   |  Tidak| *

        */

        date_default_timezone_set("Asia/Jakarta");
        $today = "'".date("Y-m-d")."'";
        $today_time = "'".date("H:i:s")."'";
        $result = array();
        $result['status'] = 0;

        $promo = ProductPromo::model()->find("product_id = '$id_product' and ( DATEDIFF(".$today.",promotion_start_date) > -1 OR promotion_start_date IS NULL) and DATEDIFF(promotion_end_date,".$today.") > -1  and (".$today_time." > start_hour && ".$today_time." < end_hour OR start_hour IS NULL OR end_hour IS NULL)");

        



        if(isset($promo)){
            $result['status'] = 3;
            if($id_user == null){
                /*
                    cek batas promo dulu. 
                    kalau masih ada sisa quota user per periode atau per hari, 
                */
                if($promo->limit_status){
                    if($promo->limit_duration == "hari"){
                        $dataUserDay = self::countPromoItemUserDay($promo->id, null);
                        $userDay = $dataUserDay['sum'];
                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{
                                $result['status'] = 2;
                            }    
                        }else{
                            $result['status'] = 1;
                            $result['unit_price_before'] = $promo->price_before_diskon;
                            $result['unit_price_after'] = $promo->price_after_diskon;
                            if($promo->limit_qty == null)
                                $result['qty'] = 100;
                            else
                                $result['qty'] = $promo->limit_qty;
                        }
                        
                    }else if($promo->limit_duration == "periode"){
                        $dataUserPeriode = self::countPromoItemUserPeriode($promo->id, null);
                        $userPeriode = $dataUserPeriode['sum'];
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{
                                $result['status'] = 2;
                            }    
                        }else{
                            $result['status'] = 1;
                            $result['unit_price_before'] = $promo->price_before_diskon;
                            $result['unit_price_after'] = $promo->price_after_diskon;
                            if($promo->limit_qty == null)
                                $result['qty'] = 100;
                            else
                                $result['qty'] = $promo->limit_qty;
                        }
                        
                    }
                }
                return $result;
            }
            if($promo->limit_status){
                $result['status'] = 2;

                if($promo->limit_duration == "hari"){
                    
                    $dataUserDay = self::countPromoItemUserDay($promo->id, $id_user);
                    //$modelCD = CartDetail::model()->find('user_id = '.$id_user .' AND id_promo_item = '. $promo->id);
                    $userDay = $dataUserDay['sum'];
                    $exist = false;
                    if(isset($dataUserDay['exist'])){
                        $exist = $dataUserDay['exist'];
                    }

                    if($promo->limit_priority == "user"){
                        // cek kalau hari ini sudah lebih dari batas user yang dapat promo, cancel promo
                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;    
                            }
                            
                        }
                        

                    }else if($promo->limit_priority == "product"){
                        if($promo->limit_user != null){
                            if($userDay < $promo->limit_user && !$exist ){
                                // BISA PROMO

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else if($userDay < $promo->limit_user && $exist){
                                
                                $productDay = self::countPromoItemProductDay($promo->id, $id_user);
                                
                                if(!isset($productDay))
                                    $productDay=0;
                                else
                                    $productDay=$productDay['sum'];
                                
                                if($promo->limit_qty != null){
                                    if($promo->limit_qty - $productDay > 0){
                                        $result['status'] = 1;
                                        $result['unit_price_before'] = $promo->price_before_diskon;
                                        $result['unit_price_after'] = $promo->price_after_diskon;
                                        
                                        if($promo->limit_qty == null)
                                            $result['qty'] = 100;
                                        else
                                            $result['qty'] = $promo->limit_qty - $productDay;    
                                    }else{
                                        $result['status'] = 2;
                                    }    
                                }else{
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else
                                        $result['qty'] = $promo->limit_qty - $productDay;    
                                }
                                
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{

                                $productDay = self::countPromoItemProductDay($promo->id, $id_user);
                                
                                if(!isset($productDay))
                                    $productDay=0;
                                else
                                    $productDay=$productDay['sum'];

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                
                                if($promo->limit_qty - $productDay > 0){
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else
                                        $result['qty'] = $promo->limit_qty - $productDay;    
                                }else{
                                    $result['status'] = 2;
                                } 
                            }
                        }
                        
                    }
                }else if($promo->limit_duration == "periode"){ 

                    $dataUserPeriode = self::countPromoItemUserPeriode($promo->id, $id_user);
                    $userPeriode = $dataUserPeriode['sum'];
                    $exist = false;
                    if(isset($dataUserPeriode['exist'])){
                        $exist = $dataUserPeriode['exist'];
                    }
                    if($promo->limit_priority == "user"){
                        // cek kalau hari ini sudah lebih dari batas user yang dapat promo, cancel promo
                        
                        
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;    
                            }
                            
                        }
                        

                    }else if($promo->limit_priority == "product"){
                        if($promo->limit_user != null){
                            if($userPeriode < $promo->limit_user && !$exist){
                                // BISA PROMO
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else if($userPeriode < $promo->limit_user && $exist){
                                $productPeriode = self::countPromoItemProductPeriode($promo->id, $id_user);
                                if(!isset($productPeriode))
                                    $productPeriode=0;
                                else
                                    $productPeriode=$productPeriode['sum'];


                                if($promo->limit_qty != null){
                                    if($promo->limit_qty - $productPeriode > 0){
                                        $result['status'] = 1;
                                        $result['unit_price_before'] = $promo->price_before_diskon;
                                        $result['unit_price_after'] = $promo->price_after_diskon;
                                        if($promo->limit_qty == null)
                                            $result['qty'] = 100;
                                        else                                    
                                            $result['qty'] = $promo->limit_qty - $productPeriode;
                                    }else{
                                        $result['status'] = 2;
                                    }
                                }else{
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else                                    
                                        $result['qty'] = $promo->limit_qty - $productPeriode;
                                }
                                
                                
                            }    
                        }else{
                            if(!$exist){
                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                if($promo->limit_qty == null)
                                    $result['qty'] = 100;
                                else
                                    $result['qty'] = $promo->limit_qty;
                            }else{

                                $productPeriode = self::countPromoItemProductPeriode($promo->id, $id_user);
                                if(!isset($productPeriode))
                                    $productPeriode=0;
                                else
                                    $productPeriode=$productPeriode['sum'];

                                $result['status'] = 1;
                                $result['unit_price_before'] = $promo->price_before_diskon;
                                $result['unit_price_after'] = $promo->price_after_diskon;
                                
                                if($promo->limit_qty - $productPeriode > 0){
                                    $result['status'] = 1;
                                    $result['unit_price_before'] = $promo->price_before_diskon;
                                    $result['unit_price_after'] = $promo->price_after_diskon;
                                    if($promo->limit_qty == null)
                                        $result['qty'] = 100;
                                    else                                    
                                        $result['qty'] = $promo->limit_qty - $productPeriode;
                                }else{
                                    $result['status'] = 2;
                                }
                            }
                        }
                        
                    }
                }

            }else{
                $result['status'] = 3;
            }
        }
        return $result;

    }


    public static function checkTroliPromoItem($id){
        // dibagian sini update qty dan harga untuk barang promo
        // notify user kalau ada perubahan qty dan harga
        /*
            iterate all product di cart
            setiap product check promo nya lagi. 
            kembalikan nilai qty dan harga yang sesuai dengan usernya. 

            remove barang yang lama. 
            add lagi dengan harga dan qty yang diperbolehkan. 
        */
        //ambil all id productnya. 
        //query promo product ke DB

        date_default_timezone_set("Asia/Jakarta");
        $today = "'".date("Y-m-d")."'";
        $today_time = "'".date("H:i:s")."'";
        $idP = array();
        $strP = "";
        foreach (Yii::app()->shoppingCart->getPositions() as $position){
            array_push($idP, $position->id);
            if($strP == ""){
                $strP .= $position->id;
            }else{
                $strP .= ',' . $position->id;
            }
        }

        $checkPromo = array();
        $checkPromoForReport = array();
        $checkLimit = array();
        if(isset($strP) && $strP != ""){
            $promoList = ProductPromo::model()->findAll("product_id in (".$strP.") and ( DATEDIFF(".$today.",promotion_start_date) > -1 OR promotion_start_date IS NULL) and DATEDIFF(promotion_end_date,".$today.") > -1  and (".$today_time." > start_hour && ".$today_time." < end_hour OR start_hour IS NULL OR end_hour IS NULL)");
            foreach ($promoList as $key) {
                if ($key->limit_status == true || $key->limit_status == 1 || $key->limit_status == "1") {
                    $checkPromo[$key->product_id] = $key;
                }

                $checkPromoForReport[$key->product_id] = $key;
            }
            $limitList = ProductLimit::model()->findAll("product_id in (".$strP.") and ( DATEDIFF(".$today.",start_date) > -1 OR start_date IS NULL) and DATEDIFF(end_date,".$today.") > -1  and (".$today_time." > start_hour && ".$today_time." < end_hour OR start_hour IS NULL OR end_hour IS NULL)");
            foreach ($limitList as $keyLimit) {
                if ($keyLimit->limit_status == true || $keyLimit->limit_status == 1 || $keyLimit->limit_status == "1") {
                    $checkLimit[$keyLimit->product_id] = $keyLimit;
                }
            }

            $change = array();
            $tmpCart = Yii::app()->shoppingCart->getPositions();
            $dataPromoItem = array();
            $dataPromoItemForReport = array();
            $checkLimitProduct = array();
            foreach ($tmpCart as $position){
                if(isset($checkPromo[$position->id]) || isset($checkPromoForReport[$position->id])){
                    //$promo = $checkPromo[$position->id];
                    $promo = VFormatter::checkPromoItem($position->id);

                    /*
                    if (isset($promo['qty']))
                        print_r($promo['qty']);
                    */

                    if (isset($checkPromoForReport[$position->id])) {
                        if ($promo['status'] == 1 || $promo['status'] == 3) {
                            $dataPromoItemForReport[$position->id] = $checkPromoForReport[$position->id]['id'];
                        }
                    }

                    if (isset($checkPromo[$position->id])) {
                        if ($promo['status'] == 1) {

                            //simpan id promo
                            $dataPromoItem[$position->id] = $checkPromo[$position->id]['id'];

                            // lihat sisa qty

                            if ($position->getQuantity() > $promo['qty']) {
                                // delete item
                                // add new item with max promo qty
                                //$model = Product::model()->findByPk($position->id);
                                //Yii::app()->shoppingCart->remove($model->id);
                                //Yii::app()->shoppingCart->put($model, $promo['qty']);
                                array_push($change, array($position->id, $promo['qty']));
                                array_push($change, array('id' => $position->id, 'qty' => $promo['qty']));
                            } else {

                                //do nothing
                            }

                        } else if ($promo['status'] == 2) {
                            // batalkan promo
                            // $tmpQty = $position->getQuantity();
                            // Yii::app()->shoppingCart->put($model, $tmpQty);
                            // array_push($change, array('id' => $position->id, 'qty' => $tmpQty));
                            $model = Product::model()->findByPk($position->id);
                            Yii::app()->shoppingCart->remove($model->getId());
                        }
                    }
                }
                //check limit
                if(!isset($promo) && isset($checkLimit[$position->id])){
                $checkLimitProduct = self::checkLimitProduct($position, $checkLimit);
                }

            }

            Yii::app()->session['dataPromoItem'] = $dataPromoItem;
            Yii::app()->session['dataPromoProductItem'] = $dataPromoItemForReport;

            if(isset($checkLimitProduct) && !empty($checkLimitProduct)){
                Yii::app()->session['dataLimitProduct'] = $checkLimitProduct['dataLimitProduct'];
                
            }

        }
        
        if(isset($change)){
            foreach ($change as $key) {
                if(isset($key['id'])){
                    Yii::app()->session['promo-item'] = true;
                    $model = Product::model()->findByPk($key['id']);
                    Yii::app()->shoppingCart->remove($model->getId());
                    Yii::app()->shoppingCart->put($model, $key['qty']);
                }
            }

            if(isset($checkLimitProduct['change']) && !empty($checkLimitProduct['change'])){
                foreach ($checkLimitProduct['change'] as $val) {
                    if(isset($val['id'])){
                        $model = Product::model()->findByPk($val['id']);
                        Yii::app()->shoppingCart->remove($model->getId());
                        Yii::app()->shoppingCart->put($model, $val['qty']);
                    }
                }
            }    
            return true;
        }else{
            return false;
        }
        
    }

    public static function checkLimitProduct($position = [], $checkLimit = []){
        if(!isset($position) || empty($position) || !isset($checkLimit) || empty($checkLimit))
            return;

        $dataLimitProduct = array();

        if(isset(Yii::app()->session['listLimitProduct'][$position->id]))
            $limit = Yii::app()->session['listLimitProduct'][$position->id];
        else
            $limit = PromoHelper::getInstance()->checkLimitItem($position->id);

        $change = array();
        if (isset($checkLimit[$position->id])) {
            if ($limit['status'] == 1) {

                            //simpan id limit
                $dataLimitProduct[$position->id] = $checkLimit[$position->id]['id'];

                            // lihat sisa qty

                if ($position->getQuantity() > $limit['qty']) {
                                // delete item
                                // add new item with max promo qty
                    array_push($change, array($position->id, $limit['qty']));
                    array_push($change, array('id' => $position->id, 'qty' => $limit['qty']));
                } else {

                                //do nothing
                }

            } else if ($limit['status'] == 2) {
                $model = Product::model()->findByPk($position->id);
                Yii::app()->shoppingCart->remove($model->getId());
            }
        }

        $result = array('dataLimitProduct' => $dataLimitProduct, 'change' => $change);

        return $result;
        
    }

    public static function random(){
        return (float)rand()/(float)getrandmax();
    }

    public static function randomChar($max){
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
                     .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                     .'0123456789'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, $max) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public static function generateVoucher($len){
        $chars = "123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
        $string_length = $len;
        $randomstring = "";
        for ($i=0; $i<$string_length; $i++) {
          $rnum = floor(self::random() * strlen($chars));
          $randomstring .= substr($chars, $rnum, 1);
        }

        return $randomstring;
    }

    public static function closeOrderSuccessSql($metodePengiriman){
        $var = "CLOSE_ORDER_PAKET";
        $filterTime = "TIMESTAMPDIFF(HOUR,cd.date, now()) > (select value from environment_variable where name = '".$var."')";
        if($metodePengiriman == 'LANGSUNG'){
            $var = "CLOSE_ORDER_ODD";
            $filterTime = "TIMESTAMPDIFF(HOUR,cd.date, now()) > (select value from environment_variable where name = '".$var."')";
        }else if($metodePengiriman == 'UNDER ONE HOUR'){
            $var = "CLOSE_ORDER_OHD";
            $filterTime = "TIMESTAMPDIFF(HOUR,cd.date, now()) > (select value from environment_variable where name = '".$var."')";
        }else if($metodePengiriman == 'AMBIL DI APOTEK'){
            $var = "CLOSE_ORDER_APOTEK";
            $filterTime = "TIMESTAMPDIFF(HOUR,cd.outlet_hour, now()) > (select value from environment_variable where name = '".$var."')";
        }

        // $sql = "SELECT cd.id AS cart_detail_id, cd.order_code, cd.name, cd.total_price FROM konfirmasi_penerimaan as kp join cart_detail as cd on cd.id = kp.cart_detail_id where TIMESTAMPDIFF(HOUR,tanggal_kirim, now()) > (select value from environment_variable where name = '".$var."') and cart_status_id != 4 and cart_status_id != 5 and shipping_method = '".$metodePengiriman."' ";

        $sql = "SELECT cd.id AS cart_detail_id, cd.order_code, cd.name, cd.total_price FROM konfirmasi_penerimaan as kp join cart_detail as cd on cd.id = kp.cart_detail_id where ".$filterTime." and cart_status_id != 4 and cart_status_id != 5 and shipping_method = '".$metodePengiriman."' LIMIT 500";

        return $sql;
    }

    public static function closeOrderSuccessSqlOksoft($shippingMethod) {
        $sql = "SELECT cart_detail.id AS cart_detail_id, 
                       cart_detail_oksoft.order_code, 
                       cart_detail.name, 
                       cart_detail.total_price 
                FROM cart_detail_oksoft 
                    join cart_detail 
                    ON cart_detail.order_code = cart_detail_oksoft.order_code 
                WHERE cart_detail.cart_status_id = 12 
                AND cart_detail.waktu_estimasi <= now()
                AND shipping_method = '" . $shippingMethod . "' 
                LIMIT 500";
        return $sql;
    }

    public static function closeOrderStatusExcepted(){
        // $env = EnvironmentVariable::getValue('CLOSE_ORDER_STATUS_EXCEPTED', 24);
        // $filterTime = "TIMESTAMPDIFF(HOUR,cd.date, now()) > ".$env;
        $sql = "SELECT cd.id AS cart_detail_id, cd.order_code, cd.name, cd.total_price FROM cart_detail as cd JOIN (select order_code, status_id from history_penanganan) as hp ON hp.order_code = cd.order_code WHERE cd.cart_status_id NOT IN (4,5,11,21) AND hp.status_id = 7 LIMIT 500";

        return $sql;
    }

    public static function konfirmasiPenerimaanSql($metodePengiriman){
        $var = "KIRIM_KONFIRMASI_PAKET";
        if($metodePengiriman == 'LANGSUNG'){
            $var = "KIRIM_KONFIRMASI_ODD";
        }else if($metodePengiriman == 'UNDER ONE HOUR'){
            $var = "KIRIM_KONFIRMASI_OHD";
        }else if($metodePengiriman == 'AMBIL DI APOTEK'){
            $var = "KIRIM_KONFIRMASI_APOTEK";
        }

        // $sql = "SELECT hp.id, u.prefix, cd.order_code, cd.id as 'cdID', cd.name, u.username, TIMESTAMPDIFF(HOUR,str_to_date(concat( hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'),NOW()) as waktu from (SELECT max(hp.id) as id FROM history_penanganan as hp where hp.status_id = 16 or hp.status_id = 17 or hp.status_id = 19 group by order_code) as SET_KIRIM join history_penanganan as hp on hp.id = SET_KIRIM.id INNER JOIN (select distinct hp.order_code from history_penanganan as hp join cart_detail as cd on cd.order_code = hp.order_code where hp.status_id != 8 and status_id != 9 and status_id != 10 and status_id != 11 and ( cd.cart_status_id = 8 or cd.cart_status_id = 9 or cd.cart_status_id = 12) and shipping_method = '".$metodePengiriman."') as SET_NO_TESTING on hp.order_code = SET_NO_TESTING.order_code join cart_detail as cd on cd.order_code = hp.order_code join user as u on u.id = cd.user_id where TIMESTAMPDIFF(HOUR,str_to_date(concat( hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'),NOW()) > (select value from environment_variable where name = '".$var."') and hp.id not in (SELECT kp.history_penanganan_id from konfirmasi_penerimaan as kp)";
        // $sql = "SELECT hp.id, u.prefix, cd.order_code, cd.id as 'cdID', cd.name, u.username, TIMESTAMPDIFF(HOUR,str_to_date(concat( hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'),NOW()) as waktu from (SELECT max(hp.id) as id FROM history_penanganan as hp group by order_code) as SET_KIRIM join history_penanganan as hp on hp.id = SET_KIRIM.id INNER JOIN (select distinct hp.order_code from history_penanganan as hp join cart_detail as cd on cd.order_code = hp.order_code where hp.status_id != 8 and status_id != 9 and status_id != 10 and status_id != 11 and ( cd.cart_status_id = 8 or cd.cart_status_id = 9 or cd.cart_status_id = 12) and shipping_method = '".$metodePengiriman."') as SET_NO_TESTING on hp.order_code = SET_NO_TESTING.order_code join cart_detail as cd on cd.order_code = hp.order_code join user as u on u.id = cd.user_id where TIMESTAMPDIFF(HOUR,str_to_date(concat( hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'),NOW()) > (select value from environment_variable where name = '".$var."') and hp.id not in (SELECT kp.history_penanganan_id from konfirmasi_penerimaan as kp)";
        $sql = "
            SELECT hp.id, u.prefix, cd.order_code, cd.id as 'cdID', cd.name, u.username,
            TIMESTAMPDIFF(HOUR, str_to_date(concat(hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'), NOW()) AS waktu
            FROM (SELECT MAX(hp.id) AS id FROM history_penanganan AS hp GROUP BY order_code) AS SET_KIRIM
            JOIN history_penanganan AS hp ON hp.id = SET_KIRIM.id
            INNER JOIN (
                SELECT DISTINCT hp.order_code
                FROM history_penanganan AS hp
                JOIN cart_detail AS cd ON cd.order_code = hp.order_code
                WHERE (cd.cart_status_id = 8 OR cd.cart_status_id = 9 OR cd.cart_status_id = 12)
                AND shipping_method = '".$metodePengiriman."' AND hp.order_code NOT IN (SELECT DISTINCT hp.order_code FROM history_penanganan AS hp JOIN cart_detail AS cd ON cd.order_code = hp.order_code LEFT JOIN cart_detail_refund AS cdr ON cdr.cart_detail_id = cd.id WHERE hp.status_id = 8 OR hp.status_id = 9 OR (hp.status_id = 10 AND cdr.type_2 = 'seluruh') OR hp.status_id = 11 AND (cd.cart_status_id = 8 OR cd.cart_status_id = 9 OR cd.cart_status_id = 12) AND shipping_method = '".$metodePengiriman."')
            ) AS SET_NO_TESTING
            ON hp.order_code = SET_NO_TESTING.order_code
            JOIN cart_detail AS cd ON cd.order_code = hp.order_code
            JOIN user AS u ON u.id = cd.user_id
            WHERE TIMESTAMPDIFF(HOUR, str_to_date(concat(hp.tanggal, concat(' ', hp.jam)), '%Y-%m-%d %H:%i:%s'),NOW()) > (SELECT value FROM environment_variable WHERE name = '".$var."')
            AND hp.id NOT IN (SELECT kp.history_penanganan_id FROM konfirmasi_penerimaan AS kp)
        ";
        return $sql;
    }

    public static function alertSql(){
        return $sql = "select outlet.id, name, email, getSaldo(outlet.id) as saldo, max(log_deposit.id) as 'deposit_id' from (select id, name, email from location where location.active = 1) as outlet join log_deposit on outlet.id = log_deposit.outlet_id group by outlet.id";
    }

    public static function updateAlertSql($startDate, $endDate){
        return $sql = "SELECT outlet.id, name, email, getNewSaldo(outlet.id, '".$startDate."', '".$endDate."') AS saldo, MAX(log_deposit.id) AS 'deposit_id' FROM (SELECT id, name, email FROM location WHERE location.active = 1) AS outlet JOIN log_deposit ON outlet.id = log_deposit.outlet_id GROUP BY outlet.id";
    }

    public static function generateReferralCode($userModel = null, $data = []) {
        $result = [
            'success' => false,
            'message' => "Terjadi kesalahan. Silakan coba beberapa saat lagi.",
            'message_debug' => ""];

        if (!isset($userModel))
            return $result;
        if (isset($userModel->referral_code) && (!isset($data['replace']) || !$data['replace']))
            return $result;

        if (isset($data['log']))
            $result['message_debug'] = $data['log'];
        $result['message_debug'] .= "|init|refBefore:".$userModel->referral_code;

        $lastRef = null;
        if (isset($data['last_referral'])) {
            $lastRef = $data['last_referral'];
        } else {
            $sysvar = Sysvar::model()->find("name = 'LAST_REFERRAL_CODE'");
            if (isset($sysvar))
                $lastRef = $sysvar->value;
        }
        $result['message_debug'] .= "|lastref:".$lastRef;

        if (!isset($lastRef))
            return $result;

        $base_ten = base_convert($lastRef, 36, 10);
        $referralCode = base_convert($base_ten + 1, 10, 36);
        $referralCode = strtoupper($referralCode);
        $result['message_debug'] .= "|referralToBe:".$referralCode;

        $exist = User::model()->find("referral_code = '" . $referralCode . "'");
        if (isset($exist)) {
            $result['message_debug'] .= "|exist|recalculate";
            $data['log'] = $result['message_debug'];
            $data['last_referral'] = $referralCode;
            return self::generateReferralCode($userModel, $data);

        } else {
            $result['message_debug'] .= "|do";
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if (!isset($sysvar))
                    $sysvar = Sysvar::model()->find("name = 'LAST_REFERRAL_CODE'");
                if (!isset($sysvar)) {
                    $sysvar = new Sysvar();
                    $sysvar->name = 'LAST_REFERRAL_CODE';
                }
                $sysvar->value = $referralCode;
                if (!$sysvar->save())
                    $result['message_debug'] .= "|sysvarSaveFail".json_encode($sysvar->getErrors());
                $userModel->referral_code = $referralCode;
                if (!$userModel->save(false))
                    $result['message_debug'] .= "|userSaveFail".json_encode($userModel->getErrors());

                $transaction->commit();
                $result['message_debug'] .= "|success";
                $result['success'] = true;
                $result['message'] = "";
                return $result;

            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
        return $result;
    }

    public static function checkSqlOjol($type = null, $startTime = 1440, $endTime = 5){
        if($type == null)
            $type = 'Gosend';

        if($type == "Gosend"){
        $sql = "SELECT cd.id, cd.date, cd.order_code FROM cart_detail cd JOIN log_go_send lgs ON lgs.order_code = cd.order_code WHERE cd.date > date_sub(now(), interval ".$startTime." minute) AND cd.date < date_sub(now(), interval ".$endTime." minute) AND lgs.id_gosend is null"; 
        }else{
        $sql = "SELECT cd.id, cd.date, cd.order_code FROM cart_detail cd JOIN log_grab lgr ON lgr.id_cart_detail = cd.id WHERE cd.date > date_sub(now(), interval ".$startTime." minute) AND cd.date < date_sub(now(), interval ".$endTime." minute) AND lgr.id_grab is null"; 
        }
       
        return $sql;
    }

    public static function getVillage($id){
        if(!isset($id) && empty($id))
            return "";

        $village = Village::model()->findByPk($id);
        if(!isset($village) && empty($village))
            return $id;

        return $village->name;
        // return $id;
    }
}