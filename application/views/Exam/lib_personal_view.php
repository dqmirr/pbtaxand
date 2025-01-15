<script>
app.controller('personal', function($scope, $http){
	$scope.library = 'personal'
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
	
	$scope.img_path = $scope.$parent.img_path + 'personal/'
	
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
	
	$scope.load_data_storage = function(code, id) {
		var check_storage = $scope.$parent.load_get_questions(code, id)
		
		if (check_storage != '' && check_storage != undefined) {
			
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
					$scope.$parent.show_petunjuk(true)
					$scope.$parent.start_timer(response.data.seconds, seconds_extra)
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
			$scope.$parent.saved_answer = { library		: $scope.library,
							code		: $scope.code,
							id		: id,
							jawaban_data	: jawaban_data
							}
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
		else {
			$scope.petunjuk_button_show = false
		}
	}
	
	$scope.next_question = function() {
		
		if ($scope.index == Object.keys($scope.questions).length - 1)
			return false
			
		$scope.questions[$scope.index].jawaban_benar = undefined
		$scope.index = parseInt($scope.index) + 1
		$scope.show_next_button = false
		
		$scope.set_quiz_last_index($scope.code, $scope.tutorial, $scope.index)

		// send answer
		$scope.$parent.send_answer($scope.$parent.saved_answer.library,
					   $scope.$parent.saved_answer.code,
					   $scope.$parent.saved_answer.id,
					   $scope.$parent.saved_answer.jawaban_data
					   )
		
		// Kalau ini test show_next_button selalu true
		/*
		if ($scope.test_show)
			$scope.show_next_button = true
		*/
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
			case 'hexaco':
				$scope.petunjuk_arr_soal = [{'soal': [''], 'opsi': [5,4,3,2,1], 'jawaban': 0}]
				
				$scope.opsi_jawaban = {0:'Sangat Setuju', 1:'Setuju', 2:'Netral', 3:'Tidak Setuju', 4:'Sangat Tidak Setuju'}
			break;
			
			case 'cti':
				$scope.petunjuk_arr_soal = [{'soal': [''], 'opsi': [5,4,3,2,1], 'jawaban': 0}]

				$scope.opsi_jawaban = {0:'Pasti Benar', 1:'Hampir/Banyak Benarnya', 2:'Ragu-ragu', 3:'Hampir/Banyak Salahnya', 4:'Pasti Salah'}
			break;
			
			case 'd3ad':
				$scope.opsi_jawaban = [];
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
})
</script>

<div ng-controller="personal" ng-init="load()" ng-cloak>
	<div ng-if="petunjuk_show && $parent.controller_library == 'personal'">
		<div class="row" ng-if="! test_show">
			<div class="col">
				<h4>Petunjuk:</h4>
			</div>
		</div>
		
		<div ng-if="sub_library_is('hexaco')">
			<div class="row">
				<div class="col">
					<p>
						<ol>
							<li>Setiap soal terdiri dari 1 pernyataan dengan 5 pilihan jawaban yaitu Sangat Setuju, Setuju, Netral, Tidak Setuju, dan Sangat Setuju. Seperti contoh di bawah ini.
								<div class="row mt-3 mb-3">
									<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
										<button type="button" ng-class="{true: 'active', false: ''}[petunjuk_arr_soal[0].jawaban == petunjuk_arr_soal[0].opsi[tombol_index]]" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_label}}</button>
									</div>
								</div>
							</li>
							<li>Pilihlah jawaban yang paling sesuai dengan diri Anda.</li>
							<li>Jawablah secara jujur dan spontan dengan mengklik salah satu dari pilihan jawaban tersebut.</li>
							<li>Jika sudah memahami petunjuk, silakan klik tombol <strong>Mulai Test</strong> untuk melanjutkan ke soal berikutnya.</li>
							<li>Waktu pengerjaan tes ini terbatas, untuk itu gunakan waktu Anda semaksimal mungkin.</li>
							<li>Selamat mengerjakan dan semoga sukses!</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('d3ad')">
			<div class="row">
				<div class="col">
					<p>
						<ol>
							<li>Setiap soal pada tes ini terdiri dari 2 pernyataan.</li>
							<li>Tugas Anda sederhana yaitu memilih salah satu pernyataan yang paling sesuai/menggambarkan diri Anda.</li>
							<li>Jika diantara kedua pernyataan tersebut tidak ada yang menggambarkan diri Anda, Anda tetap harus memilih salah satu diantara pernyataan tersebut.</li>
							<li>Jawablah secara jujur dan spontan dengan mengklik pilihan jawaban tersebut.</li>
							<li>Anda memiliki waktu pengerjaan yang terbatas, untuk itu gunakan waktu Anda semaksimal mungkin.</li>
							<li>Jika sudah memahami petunjuk, silakan klik tombol <strong>Mulai Test</strong> untuk mengerjakan persoalan berikutnya.</li>
							<li>Selamat mengerjakan dan semoga sukses!</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('cti')">
			<div class="row">
				<div class="col">
					<p>
						<ol>
							<li>Test ini terdiri dari 1 pernyataan dengan 5 pilihan jawaban yaitu Pasti Benar, Hampir/Banyak Benarnya, Ragu-ragu, Hampir/Banyak salahnya, dan Pasti Salah, seperti tampilan dibawah ini.
								<div class="row mt-3 mb-3">
									<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
										<button type="button" ng-class="{true: 'active', false: ''}[petunjuk_arr_soal[0].jawaban == petunjuk_arr_soal[0].opsi[tombol_index]]" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_label}}</button>
									</div>
								</div>
							</li>
							<li>Pilihlah jawaban yang paling sesuai dengan diri Anda.</li>
							<li>Jawablah secara jujur dan spontan dengan mengklik pilihan jawaban tersebut.</li>
							<li>Jika sudah memahami petunjuk dengan jelas, silahkan klik tombol <strong>Mulai Test</strong> untuk mulai mengerjakan soal.</li>
							<li>Anda memiliki waktu pengerjaan yang terbatas, untuk itu gunakan waktu anda semaksimal mungkin.</li>
							<li>Selamat mengerjakan dan semoga sukses!</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
		
		<div class="row" ng-if="petunjuk_button_show && ! test_show">
			<div class="col">
				<button class="btn {{btn_action_size}} btn-primary btn-block" ng-click="start_tutorial()">
					<span class="oi oi-book mr-2"></span> Start Tutorial
				</button>
			</div>
		</div>
		
		<div class="row" ng-if="lewati_tutorial">
			<div class="col">
				<button ng-click="start_test()" type="button" class="btn {{btn_action_size}} btn-warning btn-block">
					<span class="oi oi-media-play mr-2"></span> Mulai Test
				</button>
			</div>
		</div>
				
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="tutorial_show">
		<div ng-if="sub_library_is('hexaco')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col text-center mx-3" ng-repeat="soal in row.soal">
						<h1>{{soal[0]}}</h1>
						<h1>{{soal[1]}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
						<button ng-click="jawab(row.id, tombol)" ng-class="(row.jawaban_benar == true && row.jawaban == row.opsi[tombol_index]) ? 'active btn-outline-primary' : (row.jawaban_benar == false && row.selected_button == row.opsi[tombol_index]) ? 'btn-danger' : 'btn-outline-primary'" type="button" class="btn {{btn_size}} btn-block">{{tombol_label}}</button>
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
		</div>
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="test_show">
		<div ng-if="! sub_library_is('d3ad')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col text-center mx-3" ng-repeat="soal in row.soal">
						<h1>{{soal}}</h1>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col" ng-repeat="(tombol_index, tombol_label) in opsi_jawaban">
						<button ng-click="jawab(row.id, row.opsi[tombol_index])" ng-class="row.selected_button == row.opsi[tombol_index] ? 'active' : ''" type="button" class="btn {{btn_size}} btn-outline-primary btn-block">{{tombol_label}}</button>
					</div>
				</div>
			</div>
		</div>
		
		<div ng-if="sub_library_is('d3ad')">
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row mb-3" ng-repeat="soal in row.soal">
					<div class="col">
						<button ng-click="jawab(row.id, soal.id)" ng-class="row.selected_button == soal.id ? 'active' : ''" class="btn btn-outline-dark btn-block"><h4>{{soal.text}}</h4></button>
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
