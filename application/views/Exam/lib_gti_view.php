<script>
app.controller('gti', function($scope, $http){
	$scope.library = 'gti'
	$scope.sub_library = ''
	
	$scope.btn_size = 'btn-lg'
	$scope.btn_action_size = 'btn-lg'
	
	$scope.petunjuk_show = false
	$scope.petunjuk_button_show = true
	$scope.tutorial_show = false
	$scope.tanpa_tutorial = false
	
	$scope.petunjuk_arr_soal = []
	$scope.questions = []
	$scope.opsi_jawaban = []
	
	$scope.tutorial = 1
	$scope.init_index = 0
	$scope.index = $scope.init_index
	$scope.answers = {}
	$scope.code = ''
	
	$scope.url = $scope.$parent.get_questions_url
	$scope.save_url = $scope.$parent.save_answers_url
	$scope.show_next_button = false
	$scope.prepare_test = false
	$scope.test_show = false
	$scope.skip_test = false
	
	$scope.img_path = $scope.$parent.img_path + 'orientasi/'
	
	$scope.$on('reload', function(e) {
		$scope.load()
	})
	
	$scope.$on('back_to_main_menu', function(e, args) {
		if (args.library == $scope.library) {
			$scope.$parent.back_to_main_menu()
		}
	})
	
	$scope.$on('time_is_up', function(e,  args) {
		$scope.finish_arg(args.library, args.code)
	})
	
	$scope.$on('buka_petunjuk', function(e){
		$scope.petunjuk_show = true
	})
	
	$scope.$on('tutup_petunjuk', function(e){
		$scope.petunjuk_show = false
	})
	
	$scope.finish_arg = function(library, code) {
		if ($scope.library == library && $scope.code == code) {
			$scope.index = Object.keys($scope.questions).length
			$scope.show_next_button = false
			$scope.$parent.done($scope.library, $scope.code)
		}
	}
	
	$scope.finish = function() {
		$scope.index = Object.keys($scope.questions).length
		$scope.show_next_button = false
		$scope.$parent.done($scope.library, $scope.code)
		
		// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
		//$scope.$parent.next_quiz()
	}
	
	$scope.pause_timer = function(){
		if ($scope.sub_library == 'gti_2d' || $scope.sub_library == 'gti_3d' || $scope.sub_library == 'gti_kotak') {
			setCookie($scope.code+'_stop_timer', $scope.$parent.seconds)
			// pause timer
			$scope.$parent.timer_state = 'pause'
		}
	}
	
	$scope.load_data_storage = function(code, id) {
		var check_storage = $scope.$parent.load_get_questions(code, id)
		
		if (check_storage != '' && check_storage != undefined) {
			console.log("Check storage false");
			
			var response_data = jQuery.parseJSON(check_storage)
			
			// override
			clientUsername = response_data.clientUsername
			
			$scope.$parent.clientkey = response_data.clientkey
			
			$scope.questions = response_data.rows
			
			if ($scope.get_quiz_last_index(code, id)) {
				$scope.index = $scope.get_quiz_last_index(code, id)
			}
			
			if (Object.keys($scope.questions).length > 0)
			{
				$scope.show_question_index($scope.index)
			}
			
			$scope.code = code
			$scope.opsi_jawaban = response_data.opsi_jawaban
			
			if (response_data.seconds_extra)
				seconds_extra = response_data.seconds_extra
			else
				seconds_extra = 0
			
			$scope.petunjuk(response_data.sub_library)
			
			if ($scope.tutorial == 1) {
				$scope.petunjuk_show = true
				
				if (Object.keys($scope.questions).length == 0) {
					$scope.prepare_test = true
					$scope.tanpa_tutorial = true
				}
			}
			else {
                if ($scope.$parent.check_seconds_left(response_data.seconds) <= 0 )
					$scope.opsi_jawaban = []
				
				$scope.sub_library = response_data.sub_library
				$scope.test_show = true
				$scope.show_next_button = false
				$scope.$parent.show_petunjuk(true)
				$scope.$parent.start_timer(response_data.seconds, seconds_extra)
			}
			
			return true
		}
		
		return false
	}
	
	$scope.get_data = function(code) {
		// Reset
		$scope.index = $scope.init_index
		$scope.questions = []
		$scope.answers = {}
		$scope.show_next_button = false
		$scope.code = ''
		$scope.tutorial_show = false
		$scope.petunjuk_show = false
		$scope.tanpa_tutorial = false
		$scope.opsi_jawaban = []
		$scope.skip_test = false
		
		if ($scope.quiz_stat[code] != null) {
			$scope.index = $scope.quiz_stat[code]
		}
		
		if ($scope.$parent.get_quiz_stat(code) != undefined) {
			$scope.tutorial = $scope.$parent.get_quiz_stat(code)
		}
		
		if ($scope.load_data_storage(code, $scope.tutorial)) {
			$scope.pause_timer();
			return true;
		}
		/*
		else {
			$scope.set_quiz_last_index(code, $scope.tutorial, 0)
			$scope.index = 0
		}
		*/
		
		$http({
			url: $scope.url,
			method: 'post',
			data: $.param({library: $scope.library, code: code, tutorial: $scope.tutorial}),
			dataType: 'Json',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(function(response){

			if (response.data.success) {
				
				$scope.$parent.save_get_questions(code, $scope.tutorial, response.data)
				
				if (response.data.redirect) {
					if (response.data.msg)
						alert(response.data.msg)
					setCookie(code+'_'+clientUsername, 1)
					window.location.href = response.data.redirect
					return
				}
				
				// override
				clientUsername = response.data.clientUsername
				
				$scope.$parent.clientkey = response.data.clientkey
				
				$scope.questions = response.data.rows
				$scope.code = code
				$scope.opsi_jawaban = response.data.opsi_jawaban
				
				if (Object.keys($scope.questions).length > 0)
				{
					$scope.show_question_index($scope.index)
				}
				
				if ($scope.tutorial == 1) {
					$scope.petunjuk(response.data.sub_library)
					$scope.petunjuk_show = true
					
					if (Object.keys($scope.questions).length == 0) {
						$scope.prepare_test = true
						$scope.tanpa_tutorial = true
					}
				}
				else {
					if (response.data.seconds <= 0) $scope.opsi_jawaban = []
					$scope.sub_library = response.data.sub_library
					$scope.test_show = true
					$scope.show_next_button = false
					$scope.$parent.show_petunjuk(true)
					$scope.$parent.start_timer(response.data.seconds)
					
					$scope.pause_timer();
				}
			}
		})
	}
	
	$scope.jawab = function(id, jawaban) {
		if ($scope.questions[$scope.index].jawaban != undefined) {
			
			$scope.questions[$scope.index].selected_button = jawaban
			
			if (jawaban == $scope.questions[$scope.index].jawaban) {
				$scope.questions[$scope.index].jawaban_benar = true
				$scope.show_next_button = true
				
				var questions_length = Object.keys($scope.questions).length
		
				if (($scope.index + 1) == questions_length) {
					$scope.prepare_test = true
					$scope.show_next_button = false
				}
			}
			else {
				$scope.questions[$scope.index].jawaban_benar = false
				$scope.show_next_button = false
				$scope.prepare_test = false
			}
		}
		else {
			$scope.questions[$scope.index].selected_button = jawaban
			$scope.show_next_button = true
			
			jawaban_data = {}
			jawaban_data[id] = jawaban
			
			// Kirim jawaban partial
			// $scope.$parent.send_answer($scope.library, $scope.code, id, jawaban_data)
			$scope.$parent.saved_answer = {	library: $scope.library,
							code: $scope.code,
							id: id,
							jawaban_data: jawaban_data}
		}
	}
	
	$scope.load = function() {
		// Reset
		$scope.petunjuk_show = false
		$scope.petunjuk_button_show = true
		$scope.tutorial_show = false
		$scope.show_next_button = false
		$scope.prepare_test = false
		$scope.test_show = false
		$scope.tutorial = 1
		
		// Check parent Load
		var code = $scope.$parent.load($scope.library)
		
		if (code != undefined) {
			$scope.$parent.show_petunjuk(false)
			$scope.$parent.force_stop_timer()
			if ($scope.quiz_stat[code] != null) {
				$scope.code = code;
				$scope.tutorial = 0;
				$scope.index = $scope.quiz_stat[code]
				$scope.start_test()
			}
			else
				$scope.get_data(code)
		}
	}
	
	$scope.next_question = function() {
		if ($scope.index == Object.keys($scope.questions).length - 1)
			return false
			
		$scope.questions[$scope.index].jawaban_benar = undefined
		$scope.index = parseInt($scope.index) + 1
		$scope.show_next_button = false
		
        if ($scope.tutorial == 'false' || !$scope.tutorial) {
            $scope.set_quiz_last_index($scope.code, $scope.tutorial, $scope.index)
		}
        
		$scope.pause_timer();

		$scope.$parent.send_answer($scope.$parent.saved_answer.library,
					   $scope.$parent.saved_answer.code,
					   $scope.$parent.saved_answer.id,
					   $scope.$parent.saved_answer.jawaban_data
					   )
		
		// Kalau ini test show_next_button selalu true
		if ($scope.test_show)
			$scope.show_next_button = false

	}
	
	$scope.prev_question = function() {
		if ($scope.index > 0)
			$scope.index = $scope.index - 1
	}
	
	$scope.has_prev = function() {
		if ($scope.index == 0)
			return false
		else
			return true
	}
	
	$scope.has_next = function() {
		if ($scope.index == Object.keys($scope.questions).length - 1) {
			$scope.skip_test = true
			return false
		}
		else {
			$scope.skip_test = false
			return true
		}
	}
	
	$scope.petunjuk = function(sub_library) {
		
		$scope.sub_library = sub_library
		
		switch (sub_library) {
			case 'gti_pci':
				$scope.petunjuk_arr_soal = [{'soal': [['F','f'],['G','c'],['R','r'],['S','s']], 'opsi': [0,1,2,3,4], 'jawaban': 3, 'jawaban_text': 'Tiga'}]

				$scope.opsi_jawaban = [0,1,2,3,4]
				$scope.sasaran = 'kesamaan'
				$scope.sasaran_short = 'sama'
			break;
			
			case 'gti_pci_r':
				$scope.petunjuk_arr_soal = [{'soal': [['F','f'],['G','c'],['R','r'],['S','s']], 'opsi': [0,1,2,3,4], 'jawaban': 1, 'jawaban_text': 'Satu'}]

				$scope.opsi_jawaban = [0,1,2,3,4]
				$scope.sasaran = 'perbedaan'
				$scope.sasaran_short = 'berbeda'
			break;
			
			case 'gti_penalaran':
				$scope.petunjuk_arr_soal = [{'soal': ['Anton lebih berat daripada Dodi', 'Siapa yang terberat?'], 'opsi': ['Anton', 'Dodi'], 'jawaban': 0}]
				$scope.opsi_jawaban = [0,1,2]
			break;
			
			case 'gti_penalaran_2':
				$scope.petunjuk_arr_soal = [{'soal': ['Bonita lebih tua dari Edina, Edina lebih tua dari Puput, Puput lebih tua dari Evita. Manakah pernyataan di bawah ini yang paling benar?'], 'opsi': ['Evita lebih tua dari Puput', 'Puput lebih muda dari Bonita', 'Edina lebih muda dari Puput', 'Edina lebih tua dari Bonita', 'Edina lebih muda dari Evita'], 'jawaban': 1}]
				$scope.opsi_jawaban = [0,1,2,3,4]
			break;
			
			case 'gti_jh':
				$scope.petunjuk_arr_soal = [{'soal': ['B','E','I'], 'opsi': ['B','I'], 'jawaban': 1, 'jawaban_value': 'I', 'jawaban_detail': 'F;G;H'}]
				$scope.opsi_jawaban = [0,1]
				$scope.sasaran = 'terjauh'
				$scope.sasaran_short = 'besar'
			break;
			
			case 'gti_jh_r':
				$scope.petunjuk_arr_soal = [{'soal': ['B','E','I'], 'opsi': ['B','I'], 'jawaban': 0, 'jawaban_value': 'B', 'jawaban_detail': 'C;D'}]
				$scope.opsi_jawaban = [0,1]
				$scope.sasaran = 'terdekat'
				$scope.sasaran_short = 'kecil'
			break;
			
			case 'gti_kka':
				$scope.petunjuk_arr_soal = [{'soal': [], 'opsi': ['A','B','C'], 'jawaban': 2}, {'soal': [], 'opsi': ['A','B','C'], 'jawaban': 0, 'jawaban_rinci': 'F;G;H'}]
				$scope.opsi_jawaban = [0,1,2]
				$scope.sasaran = 'terjauh'
			break;
			
			case 'gti_kka_r':
				$scope.petunjuk_arr_soal = [{'soal': [], 'opsi': ['A','B','C'], 'jawaban': 0}, {'soal': [], 'opsi': ['A','B','C'], 'jawaban': 1, 'jawaban_rinci': 'C;D'}]
				$scope.opsi_jawaban = [0,1,2]
				$scope.sasaran = 'terdekat'
			break;
			
			case 'gti_orientasi':
				$scope.petunjuk_arr_soal = [{'soal': [[6,7],[8,5],[3,4]], 'opsi': [0,1,2,3], 'jawaban': 0}, {'soal': [[6,7],[5,3],[4,5]], 'opsi': [0,1,2,3], 'jawaban': 1},{'soal': [[7,3],[5,3],[1,2]], 'opsi': [0,1,2,3], 'jawaban': 2}]
				$scope.opsi_jawaban = [0,1,2,3]
			break;
			
			case 'gti_orientasi_2':
				$scope.petunjuk_arr_soal = [{'soal': {'prefix': 'a', 'img': [[6,7],[8,5],[3,4]]}, 'opsi': [0,1,2,3], 'jawaban': 0}, {'soal': {'prefix': 'b', 'img': [[6,7],[5,3],[4,5]]}, 'opsi': [0,1,2,3], 'jawaban': 1}]
				$scope.opsi_jawaban = [0,1,2,3]
			break;
			
			case 'gti_kotak':
				$scope.petunjuk_prefix_img = 'petunjuk_'
				$scope.petunjuk_jawaban = 6
				$scope.opsi_jawaban = [{1:1,2:2,3:3,4:4},{5:5,6:6,7:7,8:8}]
			break;
		}
	}
	
	$scope.reload_questions = function() {
		$scope.questions[$scope.index].jawaban_benar = undefined
		$scope.index = $scope.init_index
		$scope.show_next_button = false
		$scope.prepare_test = false
	}
	
	$scope.sub_library_is = function(sub_library) {
		if (sub_library == $scope.sub_library) {
			return true
		}
		else {
			return false
		}
	}
	
	$scope.start_test = function() {
		$scope.tutorial = false
		$scope.$parent.set_quiz_stat($scope.code, $scope.tutorial)
		$scope.get_data($scope.code)
	}
	
	$scope.start_tutorial = function() {
		$scope.petunjuk_show = false
		$scope.petunjuk_button_show = false
		$scope.tutorial_show = true
		
		$scope.$parent.show_petunjuk(true)
	}
	
	$scope.show_question_index = function(index) {
		if ($scope.questions != undefined)
			$scope.questions[index].show = true
	}
});
</script>

<div ng-controller="gti" ng-init="load()" ng-cloak>
	<div ng-if="petunjuk_show && $parent.controller_library == 'gti'">
		<div ng-if="sub_library_is('gti_pci') || sub_library_is('gti_pci_r')">
			<div class="row">
				<div class="col">
					Lihat Contoh sebagai berikut:
				</div>
			</div>
			<div class="row">
				<div class="col text-center mx-3" ng-repeat="soal in petunjuk_arr_soal[0].soal">
					<h1>{{soal[0]}}</h1>
					<h1>{{soal[1]}}</h1>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col" ng-repeat="tombol in opsi_jawaban">
					<button type="button" ng-class="{true: 'active', false: ''}[petunjuk_arr_soal[0].jawaban == {{tombol}}]" class="btn {{btn_size}} btn-outline-primary btn-block">{{petunjuk_arr_soal[0].opsi[tombol]}}</button>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>Pada tes ini, Anda akan dihadapkan pada pasangan huruf (baris atas dan baris bawah).</p>
					<p>Tugas Anda adalah menghitung dari keempat pasangan huruf yang ada, <strong>berapa jumlah pasangan huruf yang memiliki {{sasaran}}</strong> antara huruf yang berada di baris atas dengan huruf yang tepat berada di baris bawahnya. </p>
					<p>
						Pada contoh di atas, pasangan pertama huruf {{petunjuk_arr_soal[0].soal[0][0]}} dan {{petunjuk_arr_soal[0].soal[0][1]}} merupakan huruf yang sama.
						<br />
						{{petunjuk_arr_soal[0].soal[2][0]}} dan {{petunjuk_arr_soal[0].soal[2][1]}} serta {{petunjuk_arr_soal[0].soal[3][0]}} dan {{petunjuk_arr_soal[0].soal[3][1]}}, pasangan ketiga dan keempat juga merupakan huruf yang sama.
					</p>
					<p>
						Pasangan kedua yakni {{petunjuk_arr_soal[0].soal[1][0]}} dan {{petunjuk_arr_soal[0].soal[1][1]}}, adalah pasangan yang <u>tidak sama</u>.
					</p>
					<p>
						Pada contoh di atas terdapat {{petunjuk_arr_soal[0].jawaban}} pasangan huruf yang {{sasaran_short}}. Oleh karena itu, jawaban yang benar untuk persoalan ini adalah {{petunjuk_arr_soal[0].jawaban}} ({{petunjuk_arr_soal[0].jawaban_text}}).
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_penalaran') || sub_library_is('gti_penalaran_2')">
			<div class="row">
				<div class="col">
					<p>
						Setiap pertanyaan mengenai siapa yang lebih berat atau lebih ringan, siapa lebih tinggi atau lebih pendek, dan perbandingan-perbandingan lainnya dengan orang di sekitarnya.
					</p>
					<p>
						Simaklah dengan baik contoh-contoh berikut ini:
					</p>
				</div>
			</div>
			<div ng-repeat="row in petunjuk_arr_soal">
				<div class="row mb-3" ng-repeat="soal in row.soal">
					<div class="col text-center">
						<h1>{{soal}}</h1>
					</div>
				</div>
				<div class="row mb-3" ng-if="sub_library_is('gti_penalaran')">
					<div class="col" ng-repeat="tombol in opsi_jawaban" ng-if="row.opsi[tombol]">
						<button ng-class="tombol == row.jawaban ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row mb-3" ng-if="sub_library_is('gti_penalaran_2')" ng-repeat="tombol in opsi_jawaban" ng-if="row.opsi[tombol]">
					<div class="col">
						<button ng-class="tombol == row.jawaban ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_jh') || sub_library_is('gti_jh_r')">
			<div class="row">
				<div class="col">
					<p>
						Pada saat mengerjakan tes ini, Anda harus <u>mengingat urutan huruf</u>.
					</p>
					<p>
						Perhatikan setiap kotak terdiri dari tiga buah huruf. Ingat selalu urutan huruf itu. Kemudian pilihlah satu huruf {{sasaran}} selisihnya dari huruf yang terletak di tengah, jika telah diurutkan secara benar, pilihlah huruf yang tersedia.
					</p>
					<p>
						Berikut contoh:
					</p>
				</div>
			</div>
			<div ng-repeat="row in petunjuk_arr_soal">
				<div class="row mb-3">
					<div class="col border px-3 mx-3" ng-repeat="soal in row.soal">
						<h1 class="text-center">{{soal}}</h1>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban" ng-if="row.opsi[tombol]">
						<button ng-class="tombol == row.jawaban ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>
						Jika diurutkan secara benar maka huruf <strong>{{petunjuk_arr_soal[0].soal[0]}}</strong> ada di urutan pertama, kemudian huruf <strong>{{petunjuk_arr_soal[0].soal[1]}}</strong> dan terakhir huruf <strong>{{petunjuk_arr_soal[0].soal[2]}}</strong> berdasarkan urutan hurufnya.
					</p>
					<p>
						Tugas Anda adalah mencari selisih yang {{sasaran}} dari huruf yang ada di tengah (huruf {{petunjuk_arr_soal[0].soal[1]}}) dengan huruf yang ada di sebelah kiri (huruf {{petunjuk_arr_soal[0].soal[0]}}) atau dengan huruf yang ada di sebelah kanan (huruf {{petunjuk_arr_soal[0].soal[2]}}).
					</p>
					<p>
						<table align="center" cellpadding="5" border="0">
							<tbody>
								<tr>
									<td><h1 class="mr-3">{{petunjuk_arr_soal[0].soal[0]}}</h1></td>
									<td><h4 class="text-secondary"><u>C</u></h4></td>
									<td><h4 class="text-secondary"><u>D</u></h4></td>
									
									<td><h1 class="mr-3 ml-3">{{petunjuk_arr_soal[0].soal[1]}}</h1></td>
									<td><h4 class="text-secondary"><u>F</u></h4></td>
									<td><h4 class="text-secondary"><u>G</u></h4></td>
									<td><h4 class="text-secondary"><u>H</u></h4></td>
									
									<td><h1 class="ml-3">{{petunjuk_arr_soal[0].soal[2]}}</h1></td>
								</tr>
								<tr valign="top">
									<td align="right" colspan="3">
										<span class="text-secondary selisih rotate r90">}</span>
										<br />
										2 Huruf
									</td>
									<td></td>
									<td align="center" colspan="3">
										<span class="text-secondary selisih rotate r90">}</span>
										<br />
										3 Huruf
									</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</p>
					<p ng-if="sub_library_is('gti_jh')">
						Jawaban yang benar adalah <u>Huruf {{petunjuk_arr_soal[0].jawaban_value}}</u> karena memiliki selisih yang lebih {{sasaran_short}} (3 huruf) yaitu {{petunjuk_arr_soal[0].jawaban_detail}}. Sedangkan antara huruf {{petunjuk_arr_soal[0].soal[0]}} dan huruf {{petunjuk_arr_soal[0].soal[1]}} hanya memiliki 2 huruf: C dan D. Oleh karena itu pilihan jawaban yang tepat adalah <strong>{{petunjuk_arr_soal[0].jawaban_value}}</strong>.
					</p>
					<p ng-if="sub_library_is('gti_jh_r')">
						Jawaban yang benar adalah <u>Huruf {{petunjuk_arr_soal[0].jawaban_value}}</u> karena memiliki selisih yang lebih {{sasaran_short}} (2 huruf) yaitu {{petunjuk_arr_soal[0].jawaban_detail}}. Sedangkan antara huruf {{petunjuk_arr_soal[0].soal[1]}} dan huruf {{petunjuk_arr_soal[0].soal[2]}} memiliki 3 huruf: F, G dan H. Oleh karena itu pilihan jawaban yang tepat adalah <strong>{{petunjuk_arr_soal[0].jawaban_value}}</strong>.
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_kka') || sub_library_is('gti_kka_r')">
			<div class="row">
				<div class="col">
					<p>
						Pilihlah angka <strong>tertinggi</strong> dan <strong>terendah</strong> dari setiap perangkat bilangan yang terdiri dari 3 angka. Kemudian tetapkan dimana angka yang <strong>{{sasaran}} selisihnya</strong> dari angka yang tersisa/angka yang di <strong>tengah</strong> (<span class="text-danger">bukan bilangan yang tertinggi atau terendah</span>).
					</p>
					<p>
						Berikut Contoh:
					</p>
					<p>
						<table align="center">
							<tbody>
								<tr align="right">
									<td rowspan="3">
										<table style="height: 80px;">
											<tbody>
												<tr>
													<td align="right"><h4 style="position: relative; top: 5px; margin-right: 10px;">8</h4></td>
													<td><h1>{</h1></td>
												</tr>
												<tr>
													<td align="right"><h4 style="position: relative; top: -5px; margin-right: 10px;">10, 11, 12</h4></td>
													<td><h1 style="position: relative; top: -10px;">{</h1></td>
												</tr>
											</tbody>
										</table>
									</td>
									
									<td rowspan="3" width="10px;">&nbsp;</td>
									
									<td><h2>7</h2></td>
									<td rowspan="3" width="30px;">&nbsp;</td>
									<td><h2>A</h2></td>
								</tr>
								<tr align="right">
									<td><h2>9</h2></td>
									<td><h2>B</h2></td>
								</tr>
								<tr align="right">
									<td><h2>13</h2></td>
									<td><h2>C</h2></td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
			<div class="row mb-3 mt-3">
				<div class="col" ng-repeat="tombol in opsi_jawaban">
					<button ng-class="tombol == petunjuk_arr_soal[0].jawaban ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block">{{petunjuk_arr_soal[0].opsi[tombol]}}</button>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>
						Setelah angka-angka diurutkan dalam pikiran Anda, maka diketahui angka 7 adalah angka terendah, dan angka 13 adalah angka tertinggi.
					</p>
					<p>
						Angka manakah di antara dua angka tersebut yang {{sasaran}} jaraknya dari angka yang berada di tengah (angka 9)?
					</p>
					<p ng-if="sub_library_is('gti_kka')">
						Jawabannya adalah angka 13, karena di antara angka 7 dengan angka 9 hanya ada satu angka yaitu: 8. Sedangkan di antara angka 9 dan 13 terdapat tiga angka yaitu: 10,11,12. Oleh karena itu jawaban yang benar adalah huruf C.
					</p>
					<p ng-if="sub_library_is('gti_kka_r')">
						Jawabannya adalah angka 7, karena di antara angka 9 dengan angka 13 ada tiga angka yaitu: 10,11,12. Sedangkan di antara angka 7 dan 9 hanya terdapat satu angka yaitu 8. Oleh karena itu jawaban yang benar adalah huruf A.
					</p>
					<p>
						Contoh lainnya:
					</p>
					<p>
						<table align="center">
							<tbody>
								<tr align="right">									
									<td><h2>13</h2></td>
									<td rowspan="3" width="30px;">&nbsp;</td>
									<td><h2>A</h2></td>
								</tr>
								<tr align="right">
									<td><h2>4</h2></td>
									<td><h2>B</h2></td>
								</tr>
								<tr align="right">
									<td><h2>8</h2></td>
									<td><h2>C</h2></td>
								</tr>
							</tbody>
						</table>
					</p>
				</div>
			</div>
			<div class="row mb-3 mt-3">
				<div class="col" ng-repeat="tombol in opsi_jawaban">
					<button ng-class="tombol == petunjuk_arr_soal[1].jawaban ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block">{{petunjuk_arr_soal[1].opsi[tombol]}}</button>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>
						Pada contoh ini angka tidak berurutan dari rendah ke tinggi, namun sudah diacak.
						<br />
						Tugasnya tetap sama yaitu:
						<ol>
							<li>Menemukan angka <strong>terendah</strong> dan <strong>tertinggi</strong> (dalam pikiran Anda).</li>
							<li>Tetapkan angka mana yang mempunyai selisih {{sasaran}} dari angka tersisa.</li>
							<li>Pilih jawabah sesuai huruf yang ada di samping angka pilihan Anda.</li>
							<li ng-if="sub_library_is('gti_kka')">Jawabannya adalah <strong>13</strong>, maka pilih jawaban A.</li>
							<li ng-if="sub_library_is('gti_kka_r')">Jawabannya adalah <strong>4</strong>, maka pilih jawaban B.</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_orientasi') || sub_library_is('gti_orientasi_2')">
			<div class="col">
				<div ng-if="sub_library_is('gti_orientasi')">
					<p>
						Tes ini menggunakan dua bentuk dasar, huruf F yang di atas dan di bawah ini adalah berbeda antara satu dengan yang lain meski pada bentuk awalnya sama yakni huruf F.
						<div class="text-center">
							<img ng-src="{{img_path}}a1.png" />
						</div>
					</p>
				</div>
				<div ng-if="sub_library_is('gti_orientasi_2')">
					<p>
						Tes ini menggunakan dua huruf. Huruf F dan R dengan dua bentuk dasar, huruf F dan R yang di atas dan dibawah ini adalah berbeda antara satu dengan yang lainnya meski pada bentuk awalnya sama yakni huruf F dan huruf R.
						<div class="row text-center">
							<div class="col border py-3">
								<img ng-src="{{img_path}}a5.png" />
								<br />
								<br />
								<img ng-src="{{img_path}}a4.png" />
							</div>
							<div class="col border py-3">
								<img ng-src="{{img_path}}b5.png" />
								<br />
								<br />
								<img ng-src="{{img_path}}b4.png" />
							</div>
						</div>
					</p>
				</div>
				<p>
					Di bawah ini sebenarnya adalah contoh yang SAMA antara bentuk yang ada setelah diputar 90<sup>o</sup>, 180<sup>o</sup>, atau 270<sup>o</sup>. Perputaran tersebut bisa searah jarum jam (ke kanan) atau berlawanan arah jarum jam (ke kiri).
				</p>
				<div ng-if="sub_library_is('gti_orientasi')">
					<p>
						<div class="row">
							<div class="col text-center">
								<img ng-src="{{img_path}}a1.png" />
							</div>
							<div class="col text-center">
								<img ng-src="{{img_path}}a7.png" />
							</div>
							<div class="col text-center">
								<img ng-src="{{img_path}}a3.png" />
							</div>
							<div class="col text-center">
								<img ng-src="{{img_path}}a5.png" />
							</div>
						</div>
					</p>
				</div>
				<div ng-if="sub_library_is('gti_orientasi_2')">
					<p>
						<div class="row">
							<div class="col border py-3">
								<div class="row">
									<div class="col text-center">
										<img ng-src="{{img_path}}a1.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}a2.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}a3.png" />
									</div>
								</div>
								<div class="row mt-3">
									<div class="col text-center">
										<img ng-src="{{img_path}}a4.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}a5.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}a6.png" />
									</div>
								</div>
							</div>
							<div class="col border py-3">
								<div class="row">
									<div class="col text-center">
										<img ng-src="{{img_path}}b1.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}b2.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}b3.png" />
									</div>
								</div>
								<div class="row mt-3">
									<div class="col text-center">
										<img ng-src="{{img_path}}b4.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}b5.png" />
									</div>
									<div class="col text-center">
										<img ng-src="{{img_path}}b6.png" />
									</div>
								</div>
							</div>
						</div>
					</p>
				</div>
				<p>
					&nbsp;<br />&nbsp;
				</p>
				<p>
					Perhatikan contoh berikut. Berapa banyak bentuk-bentuk di bawah ini sama seperti bentuk <strong>atasnya</strong> setelah bentuk-bentuk itu diputar?
					<br />
					<strong>Bandingkan bentuk BAWAH dengan bentuk ATASNYA</strong>.
				</p>
				<div ng-if="sub_library_is('gti_orientasi')">
					<p>
						<div ng-repeat="row in petunjuk_arr_soal">
							<div class="row">
								<div class="col-lg-6 offset-lg-3">
									<div class="row mb-5">
										<div class="col text-center" ng-repeat="soal in row.soal">
											<img ng-src="{{img_path}}a{{soal[0]}}.png" />
											<div style="height: 100px;"></div>
											<img ng-src="{{img_path}}a{{soal[1]}}.png" />
										</div>
									</div>
								</div>
							</div>
							<div class="row mb-5">
								<div class="col" ng-repeat="tombol in opsi_jawaban">
									<button ng-class="row.jawaban == tombol ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">{{row.opsi[tombol]}}</button>
								</div>
							</div>
						</div>
					</p>
				</div>
				<div ng-if="sub_library_is('gti_orientasi_2')">
					<p>
						<div ng-repeat="row in petunjuk_arr_soal">
							<div class="row">
								<div class="col-lg-6 offset-lg-3">
									<div class="row mb-5">
										<div class="col text-center" ng-repeat="soal in row.soal.img">
											<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[0]}}.png" />
											<div style="height: 100px;"></div>
											<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[1]}}.png" />
										</div>
									</div>
								</div>
							</div>
							<div class="row mb-5">
								<div class="col" ng-repeat="tombol in opsi_jawaban">
									<button ng-class="row.jawaban == tombol ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">{{row.opsi[tombol]}}</button>
								</div>
							</div>
						</div>
					</p>
				</div>
				<p>
					Pastikan Anda memahami cara menjawabnya dengan benar. <strong>Anda harus menunjukkan berapa pasangan yang SAMA.</strong>
				</p>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_2d')">
			<div class="col">
				<p>
					<ul>
						<li>Pada tes ini, Anda akan diberikan satu bentuk gambar tertentu.</li>
						<li>Tugas Anda adalah memilih dari 5(lima) pilihan jawaban yang tersedia, bentuk manakah yang sama dengan bentuk pada soal yang diberikan.</li>
						<li>Untuk mendapatkan jawabannya, bentuk tersebut dapat Anda putar dalam pikiran Anda sampai Anda menemukan bentuk yang sama pada pilihan jawaban yang tersedia.</li>
					</ul>
				</p>
				<p>
					Contoh soal:
				</p>
				<p>
					<img ng-src="{{img_path}}gti_2d.jpg" class="img-fluid" />
				</p>
				<p>
					Untuk contoh di atas, pilihan jawaban yang tepat adalah pilihan bentuk keempat (D).
				</p>
				<p>
					Cara mendapatkannya adalah dengan memutar bentuk pada soal searah dengan jarum jam (diputar ke kanan). 
				</p>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_3d')">
			<div class="col">
				<p>
					<ul>
						<li>Pada tes ini, Anda akan diberikan suatu bentuk gambar tertentu.</li>
						<li>Tugas Anda adalah memilih dari 5(lima) pilihan jawaban yang tersedia, bentuk manakah yang sama dengan bentuk pada soal yang diberikan.</li>
						<li>Untuk mendapatkan jawabannya, bentuk tersebut dapat Anda putar, Anda gulingkan, dan/atau dapat Anda putar dan gulingkan dalam pikiran Anda sampai Anda menemukan bentuk yang sama pada pilihan jawaban yang tersedia.</li>
					</ul>
				</p>
				<p>
					Contoh Soal:
				</p>
				<p>
					<img ng-src="{{img_path}}gti_3d.jpg" class="img-fluid" />
				</p>
				<p>
					Untuk contoh di atas, pilihan jawaban yang tepat adalah pilihan bentuk keempat (D).
				</p>
				<p>
					Cara mendapatkannya adalah dengan menegakkan bentuk pada soal menjadi lurus, lalu diputar ke arah belakang sehingga menghasilkan bentuk gambar seperti pada pilihan keempat.
				</p>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_kotak')">
			<div class="col">
				<p>
					Pada tes ini, Anda akan dihadapkan pada satu kotak besar yang di dalamnya terdapat suatu pola tertentu.
				</p>
				<p>
					Perhatikan bahwa di dalam kotak tersebut, ada bagian yang masih kosong. 
				</p>
				<p>
					Tugas Anda adalah melengkapi bagian kosong tersebut dengan salah satu dari 8 (delapan) pilihan jawaban yang tersedia, bentuk manakah yang cocok mengisi bagian yang kosong dengan pola pada soal yang diberikan.
				</p>
				<p>
					Contoh:
				</p>
				<p class="text-center">
					<img ng-src="{{img_path}}{{sub_library}}/{{petunjuk_prefix_img}}0.png" class="img-fluid" />
				</p>
				<div class="row mb-3" ng-repeat="baris in opsi_jawaban">
					<div class="col mb-3 text-center" ng-repeat="(key_jawaban, tombol) in baris">
						<img ng-src="{{img_path}}{{sub_library}}/{{petunjuk_prefix_img}}{{tombol}}.png" class="img-fluid" style="height: 92px;" />
						<br />
						<button ng-click="jawab(row.id, key_jawaban)" ng-class="petunjuk_jawaban == tombol ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">Pilih</button>
					</div>
				</div>
				<p>
					Bekerjalah secepat dan seteliti mungkin karena waktunya sangat terbatas!
				</p>
			</div>
		</div>
		
		<div class="row" ng-if="petunjuk_button_show && !tanpa_tutorial && ! test_show">
			<div class="col">
				<button class="btn {{btn_action_size}} btn-primary btn-block" ng-click="start_tutorial()">
					<span class="oi oi-book mr-2"></span> Start Tutorial
				</button>
			</div>
		</div>
				
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="tutorial_show">
		<div ng-if="sub_library_is('gti_pci') || sub_library_is('gti_pci_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col text-center mx-3" ng-repeat="soal in row.soal">
						<h1>{{soal[0]}}</h1>
						<h1>{{soal[1]}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-block">{{opsi_jawaban[tombol]}}</button>
					</div>
				</div>
				<div class="row">
					<div class="col mx-3 text-center" ng-class="row.jawaban_benar == true ? 'alert alert-primary' : (row.jawaban_benar == false ? 'alert alert-danger' : '')">
						<h4 ng-if="row.jawaban_benar == true">Jawaban Benar</h4>
						<h4 ng-if="row.jawaban_benar == false">Jawaban Salah</h4>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_penalaran') || sub_library_is('gti_penalaran_2')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row" ng-repeat="soal in row.soal">
					<div class="col text-center">
						<h1>{{soal}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3" ng-if="sub_library_is('gti_penalaran')">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row mt-3 mb-3" ng-if="sub_library_is('gti_penalaran_2')" ng-repeat="tombol in opsi_jawaban">
					<div class="col">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row">
					<div class="col mx-3 text-center" ng-class="row.jawaban_benar == true ? 'alert alert-primary' : (row.jawaban_benar == false ? 'alert alert-danger' : '')">
						<h4 ng-if="row.jawaban_benar == true">Jawaban Benar</h4>
						<h4 ng-if="row.jawaban_benar == false">Jawaban Salah</h4>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_jh') || sub_library_is('gti_jh_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col border px-3 mx-3" ng-repeat="soal in row.soal">
						<h3 class="text-center">{{soal}}</h3>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row">
					<div class="col mx-3 text-center" ng-class="row.jawaban_benar == true ? 'alert alert-primary' : (row.jawaban_benar == false ? 'alert alert-danger' : '')">
						<h4 ng-if="row.jawaban_benar == true">Jawaban Benar</h4>
						<h4 ng-if="row.jawaban_benar == false">Jawaban Salah</h4>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_kka') || sub_library_is('gti_kka_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col">
						<table align="center">
							<tbody>
								<tr align="right" ng-repeat="(tombol, soal) in row.soal">
									<td>
										<h2>{{soal}}</h2>
									</td>
									<td width="30px;">&nbsp;</td>
									<td>
										<h2>{{row.opsi[tombol]}}</h2>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row">
					<div class="col mx-3 text-center" ng-class="row.jawaban_benar == true ? 'alert alert-primary' : (row.jawaban_benar == false ? 'alert alert-danger' : '')">
						<h4 ng-if="row.jawaban_benar == true">Jawaban Benar</h4>
						<h4 ng-if="row.jawaban_benar == false">Jawaban Salah</h4>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_orientasi') || sub_library_is('gti_orientasi_2')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row" ng-if="sub_library_is('gti_orientasi')">
					<div class="col-lg-6 offset-lg-3">
						<div class="row mb-5">
							<div class="col text-center" ng-repeat="soal in row.soal">
								<img ng-src="{{img_path}}a{{soal[0]}}.png" />
								<div style="height: 100px;"></div>
								<img ng-src="{{img_path}}a{{soal[1]}}.png" />
							</div>
						</div>
					</div>
				</div>
				<div class="row" ng-if="sub_library_is('gti_orientasi_2')">
					<div class="col-lg-6 offset-lg-3">
						<div class="row mb-5">
							<div class="col text-center" ng-repeat="soal in row.soal.img">
								<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[0]}}.png" />
								<div style="height: 100px;"></div>
								<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[1]}}.png" />
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == tombol) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == tombol) ? 'btn-danger' : 'btn-outline-primary'" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row">
					<div class="col mx-3 text-center" ng-class="row.jawaban_benar == true ? 'alert alert-primary' : (row.jawaban_benar == false ? 'alert alert-danger' : '')">
						<h4 ng-if="row.jawaban_benar == true">Jawaban Benar</h4>
						<h4 ng-if="row.jawaban_benar == false">Jawaban Salah</h4>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row" ng-if="show_next_button">
			<div class="col">
				<button ng-click="next_question()" type="button" class="btn {{btn_action_size}} btn-outline-success btn-block">
					Pertanyaan Berikutnya
					<span class="oi oi-chevron-right ml-2 t3"></span>
				</button>
			</div>
		</div>
		
		<div ng-if="prepare_test" class="row">
			<div class="col">
				<button ng-click="reload_questions()" type="button" class="btn {{btn_action_size}} btn-info btn-block">
					<span class="oi oi-reload mr-2"></span> Ulangi Tutorial
				</button>
			</div>
			<div class="col">
				<button ng-click="start_test()" type="button" class="btn {{btn_action_size}} btn-warning btn-block">
					<span class="oi oi-media-play mr-2"></span> Mulai Test
				</button>
			</div>
			<div class="col-12">
				<ul>
					<li>Saat sudah selesai mengerjakan tutorial, Anda dapat mengulang kembali untuk mengerjakan tutorial jika Anda belum memahami instruksi.</li>
					<li>Jika Anda sudah memahami apa yang perlu dikerjakan, silahkan langsung memilih pilihan <strong>Mulai Test</strong>.</li>
					<li>INGAT! Saat Anda sudah memilih <strong>Mulai Test</strong>, maka waktu pengerjaan Anda sudah mulai berjalan dan tidak dapat dihentikan sementara. Gunakan waktu Anda dengan sebaik-baiknya.</li>
					<li>Selamat mengerjakan!</li>
				</ul>
			</div>
		</div>
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="tanpa_tutorial">
		<div class="row">
			<div class="col">
				<button ng-click="start_test()" type="button" class="btn {{btn_action_size}} btn-warning btn-block">
					<span class="oi oi-media-play mr-2"></span> Mulai Test
				</button>
			</div>
		</div>
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="test_show">
		<div ng-if="sub_library_is('gti_pci') || sub_library_is('gti_pci_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col text-center mx-3" ng-repeat="soal in row.soal">
						<h1>{{soal[0]}}</h1>
						<h1>{{soal[1]}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{opsi_jawaban[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_penalaran') || sub_library_is('gti_penalaran_2')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row" ng-repeat="soal in row.soal">
					<div class="col text-center">
						<h1>{{soal}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3" ng-if="sub_library_is('gti_penalaran')">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
				<div class="row mt-3 mb-3" ng-if="sub_library_is('gti_penalaran_2')" ng-repeat="tombol in opsi_jawaban">
					<div class="col">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_jh') || sub_library_is('gti_jh_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col border px-3 mx-3" ng-repeat="soal in row.soal">
						<h1 class="text-center">{{soal}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_kka') || sub_library_is('gti_kka_r')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col">
						<table align="center">
							<tbody>
								<tr align="right" ng-repeat="(tombol, soal) in row.soal">
									<td>
										<h2>{{soal}}</h2>
									</td>
									<td width="30px;">&nbsp;</td>
									<td>
										<h2>{{row.opsi[tombol]}}</h2>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_orientasi') || sub_library_is('gti_orientasi_2')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row" ng-if="sub_library_is('gti_orientasi')">
					<div class="col-lg-6 offset-lg-3">
						<div class="row mb-5">
							<div class="col text-center" ng-repeat="soal in row.soal">
								<img ng-src="{{img_path}}a{{soal[0]}}.png" />
								<div style="height: 100px;"></div>
								<img ng-src="{{img_path}}a{{soal[1]}}.png" />
							</div>
						</div>
					</div>
				</div>
				<div class="row" ng-if="sub_library_is('gti_orientasi_2')">
					<div class="col-lg-6 offset-lg-3">
						<div class="row mb-5">
							<div class="col text-center" ng-repeat="soal in row.soal.img">
								<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[0]}}.png" />
								<div style="height: 100px;"></div>
								<img ng-src="{{img_path}}{{row.soal.prefix}}{{soal[1]}}.png" />
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<div class="col" ng-repeat="tombol in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">{{row.opsi[tombol]}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_2d') || sub_library_is('gti_3d')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col-lg-6 offset-lg-3 text-center">
						<img ng-src="{{img_path}}{{code}}/{{row.soal}}" class="img-fluid" style="height: 200px;" imageonload="image_loaded(code,row.index)" />
					</div>
				</div>
				<div class="row mb-3">
					<div class="col" ng-repeat="tombol in row.opsi">
						<img ng-src="{{img_path}}{{code}}/{{tombol}}" class="img-fluid" style="height: 150px;" imageonload="image_loaded(code,row.index)" />
						<br />
						<button ng-click="jawab(row.id, tombol)" ng-class="row.selected_button == tombol ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">Pilih</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('gti_kotak')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row mb-2">
					<div class="col-lg-6 offset-lg-3 text-center">
						<img ng-src="{{img_path}}{{sub_library}}/soal/{{row.soal}}" class="img-fluid" style="height: 200px;" imageonload="image_loaded(code,row.index, 9)" />
					</div>
				</div>
				<div class="row mb-2" ng-repeat="baris in row.opsi">
					<div class="col-sm-6 col-lg-3 mb-2 col-xs-12 text-center" ng-repeat="(key_jawaban, tombol) in baris">
						<img ng-src="{{img_path}}{{sub_library}}/soal/{{tombol}}" class="img-fluid" style="height: 92px;" imageonload="image_loaded(code,row.index, 9)" />
						<br />
						<button ng-click="jawab(row.id, key_jawaban)" ng-class="row.selected_button == key_jawaban ? 'active' : ''" class="btn {{btn_size}} btn-outline-primary btn-block" type="button">Pilih</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="show_next_button">
			<div class="row mb-3">
				<div class="col">
					<button ng-class="has_next() ? '' : 'disabled'" ng-click="next_question()" type="button" class="btn {{btn_action_size}} btn-outline-success btn-block">
						Pertanyaan Berikutnya
						<span class="oi oi-chevron-right ml-3 t3"></span>
					</button>
				</div>
			</div>
			<!--<div class="row">
				<div class="col">
					<button ng-class="has_prev() ? '' : 'disabled'" ng-click="prev_question()" type="button" class="btn {{btn_action_size}} btn-outline-default btn-block">
						<span class="oi oi-chevron-left mr-3 t3"></span>
						Pertanyaan Sebelumnya
					</button>
				</div>
			</div>-->
			<div class="row mt-3" ng-if="skip_test">
				<div class="col">
					<button ng-click="finish()" class="btn {{btn_action_size}} btn-warning btn-block">
						Seluruh soal pada subtes ini sudah dikerjakan, lanjutkan ke subtes berikutnya
						<span class="oi oi-media-skip-forward mr-3 t3"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
