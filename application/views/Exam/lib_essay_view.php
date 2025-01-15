<script>
app.controller('essay', function($scope, $http){
	$scope.library = 'essay'
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
			$scope.skip_test = false
			
			// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
			//$scope.$parent.next_quiz()
		}
	}
	
	$scope.finish = function() {
		$scope.index = Object.keys($scope.questions).length
		$scope.show_next_button = false
		$scope.$parent.done($scope.library, $scope.code)
		$scope.skip_test = false
		
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
		else {
			$scope.set_quiz_last_index(code, $scope.tutorial, 0)
			$scope.index = 0
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
			$scope.$parent.send_answer($scope.library, $scope.code, id, jawaban_data)
			
			return 1
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
		
		$scope.set_quiz_last_index($scope.code, $scope.tutorial, $scope.index)
		
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
		$scope.opsi_jawaban = [];
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

<div ng-controller="essay" ng-init="load()" ng-cloak>
	<div ng-if="petunjuk_show && $parent.controller_library == 'essay'">
		<div class="row">
			<div class="col">
				<h4>Petunjuk:</h4>
			</div>
		</div>
		
		<div>
			<div class="row">
				<div class="col">
					<p>
						Jawaban berupa essay dan jawablah pertanyaan dengan jawaban yang paling sesuai dengan diri Anda.
					</p>
				</div>
			</div>
		</div>
		
		<div class="row" ng-if="! test_show">
			<div class="col">
				<button ng-click="start_test()" type="button" class="btn {{btn_action_size}} btn-warning btn-block">
					<span class="oi oi-media-play mr-2"></span> Mulai Test
				</button>
			</div>
		</div>
				
		<div class="row mb-5"></div>
	</div>
	
	<div ng-if="test_show">
		<div>
			<div ng-repeat="row in questions" ng-if="row.index == index">
				<div class="row">
					<div class="col text-center mx-3">
						<h3>{{row.question}}</h3>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col">
						<textarea placeholder="isi jawaban Anda di sini..." class="form-control" ng-model="row.selected_button" rows="10"></textarea>
					</div>
				</div>
				<div class="row mt-3 mb-3">
					<div class="col">
						<button type="button" class="btn {{btn_action_size}} btn-success btn-block" ng-click="row.saved = jawab(row.id, row.selected_button)" ng-if="row.selected_button" ng-model="row.saved">Simpan Jawaban</button>
					</div>
					<div class="col" ng-if="row.saved">
						<button type="button" class="btn {{btn_action_size}} btn-primary btn-block" ng-class="has_next() ? '' : 'disabled'" ng-click="next_question()">
							Pertanyaan Selanjutnya <span class="oi oi-media-skip-forward mr-3 t3"></span>
						</button>
					</div>
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
