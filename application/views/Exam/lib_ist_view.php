<script>
app.controller('ist', function($scope, $http){
	$scope.library = 'ist'
	$scope.sub_library = ''
	
	$scope.btn_size = 'btn-lg'
	$scope.btn_action_size = 'btn-lg'
	
	$scope.petunjuk_show = false
	$scope.petunjuk_button_show = true
	$scope.tutorial_show = false
	$scope.lewati_tutorial = false
	
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
	
	$scope.img_path = $scope.$parent.img_path + 'ist/'
	$scope.img_group_path = $scope.$parent.img_path + 'ist/group/'
	$scope.group_code = {}
	
	$scope.$on('reload', function(e) {
		$scope.load()
	})
	
	$scope.$on('back_to_main_menu', function(e, args) {
		if (args.library == $scope.library) {
			$scope.$parent.back_to_main_menu()
		}
	})
	
	$scope.$on('time_is_up', function(e, args) {
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
			$scope.$parent.done(library, code)
			
			// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
			//$scope.$parent.next_quiz()
		}
	}
	
	$scope.finish = function() {
		$scope.index = Object.keys($scope.questions).length
		$scope.show_next_button = false
		$scope.$parent.done($scope.library, $scope.code)
		
		// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
		//$scope.$parent.next_quiz()
	}
	
	$scope.total_loaded = {}
	
	$scope.pause_timer = function(){
		if ($scope.sub_library == 'fa' || $scope.sub_library == 'wu') {
			setCookie($scope.code+'_stop_timer', $scope.$parent.seconds)
			// pause timer
			$scope.$parent.timer_state = 'pause'
		}
	}
	
	$scope.load_data_storage = function(code, id){
		var check_storage = $scope.$parent.load_get_questions(code, id)
		
		if (check_storage != '' && check_storage != undefined) {
			
			var response_data = jQuery.parseJSON(check_storage)
			
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
				
			if (response_data.group_code)
				$scope.group_code = response_data.group_code
			
			$scope.petunjuk(response_data.sub_library)
			
			if ($scope.tutorial == 1) {
				$scope.petunjuk_show = true
				
				if (Object.keys($scope.questions).length == 0) {
					$scope.petunjuk_button_show = false
					$scope.lewati_tutorial = true
				}
			}
			else {
				if ($scope.$parent.check_seconds_left(response_data.seconds) <= 0 )
					$scope.opsi_jawaban = []
					
				$scope.sub_library = response_data.sub_library
				$scope.test_show = true
				$scope.show_next_button = false
				$scope.petunjuk_button_show = true
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
		$scope.opsi_jawaban = []
		$scope.skip_test = false
		$scope.lewati_tutorial = false
		
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
		else {
			$scope.set_quiz_last_index(code, $scope.tutorial, 0)
			$scope.index = 0
		}
		
		// ini tidak ada tutorialnya
		if ($scope.tutorial == 2) {
			$scope.code = code
			$scope.petunjuk_show = true
			$scope.petunjuk_button_show = false
			
			// Khusus untuk jenis quiz ini, saat load langsung diset sub_librarynya
			$scope.sub_library = $scope.$parent.quiz_codes[$scope.$parent.id].sub_library
			$scope.petunjuk($scope.sub_library)
			
			return;
		}
		
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
				
				$scope.questions = response.data.rows
				
				if (Object.keys($scope.questions).length > 0)
				{
					$scope.show_question_index($scope.index)
				}
				
				$scope.code = code
				$scope.opsi_jawaban = response.data.opsi_jawaban
				
				if (response.data.seconds_extra)
					seconds_extra = response.data.seconds_extra
				else
					seconds_extra = 0
					
				if (response.data.group_code)
					$scope.group_code = response.data.group_code
				
				if ($scope.tutorial == 1) {
					$scope.petunjuk(response.data.sub_library)
					
					$scope.petunjuk_show = true
					
					if (Object.keys($scope.questions).length == 0) {
						$scope.petunjuk_button_show = false
						$scope.lewati_tutorial = true
					}
				}
				else {
					if (response.data.seconds <= 0) $scope.opsi_jawaban = []
					$scope.sub_library = response.data.sub_library
					$scope.test_show = true
					$scope.show_next_button = false
					$scope.petunjuk_button_show = true
					$scope.$parent.show_petunjuk(true)
					$scope.$parent.start_timer(response.data.seconds, seconds_extra)
					
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
			$scope.$parent.send_answer($scope.library, $scope.code, id, jawaban_data)
		}
	}
	
	$scope.load = function() {
		// Reset
		$scope.petunjuk_show = false
		$scope.petunjuk_button_show = false
		$scope.tutorial_show = false
		$scope.show_next_button = false
		$scope.prepare_test = false
		$scope.test_show = false
		$scope.tutorial = 2
		
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
		
		$scope.set_quiz_last_index($scope.code, $scope.tutorial, $scope.index)
		
		$scope.pause_timer();
		
		// Kalau ini test show_next_button selalu true
		if ($scope.test_show)
			$scope.show_next_button = false
	}
	
	$scope.prev_question = function() {
		if ($scope.index > 0)
			$scope.index = $scope.index - 1
			
		$scope.set_quiz_last_index($scope.code, $scope.tutorial, $scope.index)
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
			case 'zr':
				$scope.petunjuk_arr_soal = [{'soal': [''], 'opsi': [5,4,3,2,1], 'jawaban': 0}]
				
				$scope.opsi_jawaban = []
			break;
			
			case 'wu':
				$scope.petunjuk_arr_soal = ['wu_sample6.png', 'wu_sample7.png', 'wu_sample8.png', 'wu_sample9.png', 'wu_sample10.png']
				$scope.opsi_jawaban = {'a':'wu_sample1.png', 'b':'wu_sample2.png', 'c':'wu_sample3.png', 'd':'wu_sample4.png', 'e':'wu_sample5.png'}
			break;
			
			case 'fa':
				$scope.petunjuk_arr_soal = ['fa_sample6.png', 'fa_sample7.png', 'fa_sample8.png', 'fa_sample9.png']
				$scope.opsi_jawaban = {'a':'fa_sample1.png', 'b':'fa_sample2.png', 'c':'fa_sample3.png', 'd':'fa_sample4.png', 'e':'fa_sample5.png'}
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
	
	$scope.jawab2 = function(id, jawaban) {
		$scope.questions[$scope.index].jawaban_user = jawaban
	}
})
</script>

<div ng-controller="ist" ng-init="load()" ng-cloak>
	<div ng-if="petunjuk_show && $parent.controller_library == 'ist'">
		<div ng-if="sub_library_is('fa')">
			<div class="row">
				<div class="col">
					<p>
						Pada persoalan berikutnya, setiap soal memperlihatkan sesuatu bentuk tertentu yang terpotong menjadi beberapa bagian.
					</p>
					<p>
						Carilah di antara bentuk-bentuk yang ditentukan (a,b,c,d,e), bentuk yang dapat dibangun dengan cara menyusun potongan-potongan itu sedemikian rupa, sehingga tidak ada kelebihan sudut atau ruang di antaranya.
					</p>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
					<img class="img-fluid" ng-src="{{img_group_path}}{{ tombol_label }}" />
					<br />
					<button type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_index}}</button>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col" ng-repeat="name in petunjuk_arr_soal">
					<img class="img-fluid" ng-src="{{img_group_path}}{{ name }}" />
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>
						<strong>Contoh 6</strong>
						<br />
						Jika potongan-potongan pada contoh 6 di atas disusun (digabungkan), maka akan menghasilkan <strong>bentuk a</strong>. 
					</p>
					<p>
						<strong>Contoh berikutnya :</strong>
						<br />
						Potongan-potongan contoh 7 setelah disusun (digabungkan) menghasilkan <strong>bentuk e</strong>.
						<br />
						Contoh 8 menjadi <strong>bentuk b</strong>. 
						<br />
						Contoh 9 ialah <strong>bentuk d</strong>. 
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('wu')">
			<div class="row">
				<div class="col">
					<p>
						Ditentukan 5 (lima) buah kubus a,b,c,d,e. Pada tiap-tiap kubus terdapat enam tanda yang berlainan pada setiap sisinya. Tiga dari tanda itu dapat dilihat.
						<br />
						Kubus-kubus yang ditentukan itu (a,b,c,d,e) ialah kubus-kubus yang berbeda, artinya kubus-kubus itu dapat mempunyai tanda-tanda yang sama, akan tetapi susunannya berlainan. 
						<br />
						Setiap soal memperlihatkan salah satu kubus yang ditentukan di dalam kedudukan yang berbeda. 
						<br />
						Carilah kubus yang dimaksudkan itu dan jawablah pertanyaan tersebut dengan jawaban yang tepat. 
						<br />
						Kubus itu dapat diputar, dapat digulingkan atau dapat diputar dan digulingkan dalam pikiran Saudara. Oleh karena itu, mungkin akan terlihat suatu tanda yang baru.
					</p>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
					<img class="img-fluid" ng-src="{{img_group_path}}{{ tombol_label }}" />
					<br />
					<button type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_index}}</button>
				</div>
			</div>
			<div class="row mt-3 mb-3">
				<div class="col" ng-repeat="name in petunjuk_arr_soal">
					<img class="img-fluid" ng-src="{{img_group_path}}{{ name }}" />
				</div>
			</div>
			<div class="row">
				<div class="col">
					<p>
						<strong>Contoh 1</strong>
						<br />
						Contoh ini memperlihatkan kubus a dengan kedudukan yang berbeda. 
						<br />
						Mendapatkannya adalah dengan cara menggulingkan lebih dahulu kubus itu ke kiri satu kali dan kemudian diputar ke kiri satu kali, sehingga sisi kubus yang bertanda dua segi empat hitam terletak di depan, seperti kubus a. 
						<br />
						Maka, jawaban yang tepat adalah <strong>a</strong>. 
					</p>
					<p>
						Contoh berikutnya: 
						<br />
						<strong>Contoh nomor 2</strong> adalah <strong>kubus e</strong>.
						<br />
						Cara mendapatkannya adalah dengan digulingkan ke kiri satu kali dan diputar ke kiri satu kali, sehingga sisi kubus yang bertanda garis silang terletak di depan, seperti kubus e.  
					</p>
					<p>
						<strong>Contoh nomor 3</strong> adalah <strong>kubus b</strong>.
						<br />
						Cara mendapatkannya adalah dengan menggulingkannya ke kiri satu kali, sehingga dasar kubus yang tadinya tidak terlihat memunculkan tanda baru (dalam hal ini adalah tanda dua segi empat hitam) dan tanda silang pada sisi atas kubus itu menjadi tidak terlihat lagi. 
					</p>
					<p>
						<strong>Contoh nomor 4</strong> jawabannya adalah <strong>kubus c</strong>.
						<br />
						<strong>Contoh nomor 5</strong> jawabannya adalah <strong>kubus d</strong>. 
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('zr')">
			<div class="row">
				<div class="col">
					<p>
						Pada persoalan berikut akan diberikan deret angka. 
						<br />
						Setiap deret tersusun menurut suatu aturan yang tertentu dan dapat dilanjutkan menurut aturan itu. 
						<br />
						Carilah untuk setiap deret angka berikutnya dan ketiklah jawaban angka yang tepat. 
					</p>
					<p>
						<strong>Contoh:</strong>
						<br />
						<div class="row text-center" style="font-size: 32px;">
							<div class="col">2</div>
							<div class="col">4</div>
							<div class="col">6</div>
							<div class="col">8</div>
							<div class="col">10</div>
							<div class="col">12</div>
							<div class="col">14</div>
							<div class="col">?</div>
						</div>
					</p>
					<p>
						Pada deret ini, angka berikutnya selalu didapat jika angka di depannya ditambah dengan 2. 
						<br />
						Maka jawabannya ialah 16 
						<br />
						Oleh karena itu, Anda akan diminta untuk mengetik angka 16 pada kolom yang tersedia. Kemudian tekan tombol <strong>JAWAB</strong> sehingga tanda <strong>? (Tanda Tanya)</strong> berubah menjadi angka yang diketik tadi.
					</p>
					<p>
						<strong>Contoh berikutnya:</strong>
						<br />
						<div class="row text-center" style="font-size: 32px;">
							<div class="col">9</div>
							<div class="col">7</div>
							<div class="col">10</div>
							<div class="col">8</div>
							<div class="col">11</div>
							<div class="col">9</div>
							<div class="col">12</div>
							<div class="col">?</div>
						</div>
					</p>
					<p>
						Pada deret ini, selalu berganti-ganti, harus dikurangi dengan 2 dan setelah itu ditambah dengan 3. 
						<br />
						Jawaban contoh ini ialah : 10, maka dari itu Anda akan diminta untuk memilih angka 1 dan 0. 
					</p>
					<p>
						Kadang-kadang pada beberapa soal harus pula dikalikan atau dibagi.
					</p>
				</div>
			</div>
		</div>
		
		<div class="row" ng-if="! petunjuk_button_show">
			<div class="col">
				<button ng-click="start_test()" type="button" class="btn {{btn_action_size}} btn-warning btn-block">
					<span class="oi oi-media-play mr-2"></span> Mulai Test
				</button>
			</div>
		</div>
				
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="test_show">
		<div ng-if="! sub_library_is('zr')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="offset-lg-4 col-lg-4 col-sm-12">
						<img class="img-fluid" ng-src="{{img_path}}{{row.soal}}" imageonload="image_loaded(code,row.index)" />
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="(tombol_index, group_img) in group_code[row.group]">
						<img class="img-fluid" ng-src="{{img_group_path}}{{group_img}}" imageonload="image_loaded(code,row.index)" />
						<br />
						<button ng-click="jawab(row.id, tombol_index)" ng-class="row.selected_button == tombol_index ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_index}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('zr')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row mb-3 text-center" style="font-size: 32px;">
					<div class="col" ng-repeat="soal in row.soal track by $index">
						{{soal}}
					</div>
					<div class="col text-primary">{{ row.jawaban_user }}</div>
				</div>
				<div class="row text-center">
					<div class="col-sm-12 col-lg-4 offset-lg-4">
						<h3>Jawaban:</h3>
						
						<div class="input-group mb-3">
							<input type="text" class="form-control text-center" maxlength="2" size="2" style="font-size: 32px;" ng-model="jawaban" />
							<div class="input-group-append">
								<button ng-click="jawab(row.id, jawaban); jawab2(row.id, jawaban)" class="btn btn-primary {{btn_action_size}}" type="button">Jawab</button>
							</div>
						</div>
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
