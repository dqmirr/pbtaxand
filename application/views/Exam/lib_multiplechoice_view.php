<script>
app.controller('multiplechoice', function($scope, $http) {
	$scope.library = 'multiplechoice'
	
	$scope.answers = {}
	$scope.code = ''
	$scope.target = 1
	$scope.seconds = 0;
	$scope.init_index = 1001;
	$scope.petunjuk = true;
	$scope.index = $scope.init_index
	$scope.questions = []
	$scope.arr_story = []
	$scope.url = $scope.$parent.get_questions_url
	$scope.save_url = $scope.$parent.save_answers_url
	$scope.show_next_button = false
	$scope.started = 0 // 0 = init, 1 = Petunjuk, 2 = Mulai Quiz
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
		if (args.library == $scope.library && args.code == $scope.code) {
			$scope.index = Object.keys($scope.questions).length
			$scope.show_next_button = false
			$scope.$parent.done($scope.library, $scope.code)
			//$scope.$parent.next_quiz()
			$scope.started = 4
		}
		//$scope.save_answers()
	})
	
	$scope.answer = function(id_soal, id_jawaban) {
		$scope.answers[id_soal] = id_jawaban
		
		jawaban_data = {}
		jawaban_data[id_soal] = id_jawaban
		
		// $scope.$parent.send_answer($scope.library, $scope.code, id_soal, jawaban_data, 0)
		$scope.$parent.saved_answer = {	library		: $scope.library,
						code		: $scope.code,
						id		: id_soal,
						jawaban_data	: jawaban_data,
						done		: 0
						}
		
		var answer_length = Object.keys($scope.answers).length
		/*
		if (answer_length == $scope.target)
			$scope.show_next_button = true
		else
			$scope.show_next_button = false*/
		
		$scope.show_next_button = true
			
		var jawaban_soals = document.getElementsByClassName('jawaban_soal_'+id_soal)
		
		for (i=0; i<jawaban_soals.length; i++) {
			jawaban_soals[i].classList.remove('active')
		}
		
		document.getElementById('jawaban_soal_'+id_soal+'_'+id_jawaban).classList.add('active')
		
		/*if (Object.keys($scope.answers).length >= Object.keys($scope.questions).length) {
			$scope.skip_test = true
			//$scope.show_next_button = false
			$scope.save_answers()
		}*/
	}
	
	$scope.load_data_storage = function(code, id) {
		var check_storage = $scope.$parent.load_get_questions(code, id)
		
		if (check_storage != '' && check_storage != undefined) {
			
			var response_data = jQuery.parseJSON(check_storage)
			
			clientUsername = response_data.clientUsername
				
			$scope.$parent.clientkey = response_data.clientkey
			$scope.answers = response_data.answers
			$scope.questions = response_data.rows
			
			if ($scope.get_quiz_last_index(code, id)) {
				$scope.index = $scope.get_quiz_last_index(code, id)
				
				if ($scope.index == 0 || $scope.index == '' || $scope.index == undefined)
					$scope.index = $scope.init_index
			}

			$scope.code = code
			$scope.seconds = response_data.seconds
			
			if (response_data.arr_story) {
				$scope.arr_story = response_data.arr_story
			}
			
			$scope.$parent.start_timer($scope.seconds)		
			
			$scope.show_question_index($scope.index)
			$scope.judul = $scope.questions[$scope.index].group_name
			$scope.$parent.show_petunjuk(true)
			
			$scope.show_next_button = false
			$scope.started = 2
			
			return true
		}
		
		return false
	}
	
	$scope.get_data = function(code) {
		// Reset
		$scope.index = $scope.init_index
		$scope.questions = []
		$scope.arr_story = []
		$scope.answers = {}
		$scope.target = 1
		$scope.show_next_button = false
		$scope.code = ''
		$scope.seconds = 0
		$scope.started = 0
		$scope.skip_test = false
		
		if ($scope.quiz_stat[code] != null) {
			$scope.index = $scope.quiz_stat[code]
		}
		
		if ($scope.$parent.get_quiz_stat(code) != undefined) {
			$scope.petunjuk = $scope.$parent.get_quiz_stat(code)
		}
		
		if ($scope.load_data_storage(code, $scope.petunjuk)) {
			return true;
		}
		/*
		else {
			$scope.set_quiz_last_index(code, $scope.petunjuk, 0)
			$scope.index = $scope.init_index
		}
		*/
		
		if ($scope.petunjuk == true) {
			$scope.started = 1
			$scope.code = code
			return;
		}
		
		$http({
			url: $scope.url,
			method: 'post',
			data: $.param({library: $scope.library, code: code}),
			dataType: 'Json',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(function(response){

			if (response.data.success) {
				
				$scope.$parent.save_get_questions(code, $scope.petunjuk, response.data)
				
				// override
				clientUsername = response.data.clientUsername
				
				$scope.$parent.clientkey = response.data.clientkey
				$scope.answers = response.data.answers
				$scope.questions = response.data.rows

				$scope.code = code
				$scope.seconds = response.data.seconds
				
				if (response.data.arr_story) {
					$scope.arr_story = response.data.arr_story
				}
				
				$scope.$parent.start_timer($scope.seconds)		
				
				$scope.show_question_index($scope.index)
				$scope.judul = $scope.questions[$scope.index].group_name
				
				$scope.show_next_button = false
				$scope.started = 2
			}
		})
	}
		
	$scope.load = function() {
		// Check parent Load
		var code = $scope.$parent.load($scope.library)
		
		if (code != undefined) {
			$scope.$parent.show_petunjuk(false)
			$scope.$parent.force_stop_timer()
			$scope.petunjuk = true;
			
			if ($scope.quiz_stat[code] != null) {
				$scope.code = code;
				$scope.petunjuk = false;
				$scope.index = $scope.quiz_stat[code] 
				$scope.start_quiz()
			}
			else
				$scope.get_data(code)
		}
	}
	
	$scope.next_question = function() {
		if ($scope.has_next()) {
			// Sembunyikan semua pertanyaan yg sudah lewat
			for (i=$scope.init_index; i<=$scope.index; i++) {
				$scope.questions[i].show = false
			}
			
			$scope.index = parseInt($scope.index) + 1
			
			$scope.target = parseInt($scope.target) + 1
			
			$scope.show_question_index($scope.index)
			
			$scope.set_quiz_last_index($scope.code, $scope.petunjuk, $scope.index)
			
			if ($scope.started == 2)
				$scope.show_next_button = false
			else
				$scope.show_next_button = false
		}
		$scope.$parent.send_answer($scope.$parent.saved_answer.library,
					   $scope.$parent.saved_answer.code,
					   $scope.$parent.saved_answer.id,
					   $scope.$parent.saved_answer.jawaban_data,
					   $scope.$parent.saved_answer.done
					   )
	}
	
	$scope.prev_question = function() {
		
		if ($scope.index - 1000 > 1) {
			for (i=$scope.init_index; i<=$scope.index; i++) {
				$scope.questions[i].show = false
			}
			
			$scope.index = $scope.index - 1
			$scope.target = $scope.target - 1
			$scope.show_question_index($scope.index)
			
			$scope.set_quiz_last_index($scope.code, $scope.petunjuk, $scope.index)
		}
	}
	
	$scope.has_prev = function() {
		if ($scope.index - 1000 == 1)
			return false
		else
			return true
	}
	
	$scope.has_next = function() {
		if (($scope.index - 1000) == Object.keys($scope.questions).length) {
			$scope.skip_test = true
			return false
		}
		else {
			$scope.skip_test = false
			return true
		}
	}
	
	/*
	$scope.save_answers = function() {
		
		$http({
			url: $scope.save_url,
			method: 'post',
			data: $.param({library: $scope.library, code: $scope.code, answers: $scope.answers}),
			dataType: 'Json',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(function(response){
			// Tandai kalau sudah menjawab pertanyaan
			setCookie($scope.code+'_'+clientUsername, 1);
			
			// Selesai
			$scope.started = 3
			
			// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
			$scope.$parent.next_quiz()
		})
	}*/
	
	$scope.show_question_index = function(index) {
		if (index == undefined) 
			index = $scope.init_index
		
		$scope.questions[index].show = true
		
		// check apakah ada pertanyaan lain yg harus ditampilkan bersamaan dengan pertanyaan ini?
		if ($scope.questions[index].show_next > 0) {
			
			for (i=1; i<=$scope.questions[index].show_next; i++) {
				$scope.questions[$scope.index + i].show = true
			}
			
			$scope.index = $scope.index + $scope.questions[index].show_next
			$scope.target = $scope.target + $scope.questions[index].show_next
		}
	}
	
	$scope.start_quiz = function() {
		// Show first question
		$scope.petunjuk = false
		$scope.$parent.set_quiz_stat($scope.code, $scope.petunjuk)
		
		// Start Timer
		$scope.get_data($scope.code)
	}
	
	$scope.$watch('index', function(newValue, oldValue){
		if ($scope.questions[newValue] != undefined) {
			$scope.judul = $scope.questions[newValue].group_name
		}
	})
	
	$scope.finish = function() {
		$scope.started = 4
		$scope.index = Object.keys($scope.questions).length + 1000
		$scope.show_next_button = false
		$scope.$parent.done($scope.library, $scope.code)
		
		// Panggil Quiz berikutnya (setelah jawaban berhasil disimpan)
		//$scope.$parent.next_quiz()
	}
})
</script>

<div class="row" ng-controller="multiplechoice" ng-init="load()" ng-cloak>
	<div class="col-12" ng-if="started == 1 && $parent.controller_library == 'multiplechoice'">
		<div ng-if="code != 'english' && code != 'toeic'">
			<p class="col-12">
				<strong>Berikut adalah petunjuk pengisian kuesioner:</strong>
				<ul type="square">
					<li>Pilihlah jawaban yang paling tepat (benar) dari beberapa pilihan jawaban yang diberikan.</li>
				</ul>
			</p>
		</div>
		
		<div ng-if="code == 'english' || code == 'toeic'">
			<h4>Petunjuk {{subtest}}</h4>
			<ol>
				<li>Pada subtes ini, Anda akan dihadapkan pada dua bagian soal, <strong>Incomplete Sentences</strong> & <strong>Reading Comprehension</strong>.</li>
				<li>Pada bagian <strong>Incomplete Sentences</strong>, Anda diminta untuk memilih kata yang tepat dari 4(empat) pilihan jawaban untuk melengkapi kalimat dari masing-masing persoalan.</li>
				<li>Pada bagian <strong>Reading Comprehension</strong>, Anda diminta untuk membaca terlebih dahulu suatu bacaan yang tersedia, seperti potongan artikel, surat, majalah, dan iklan. Setelah itu, Anda diminta untuk menjawab pertanyaan sesuai dengan bacaan yang Anda baca.</li>
				<li>Selamat mengerjakan dan semoga sukses!</li>
			</ol>
		</div>
		
		<div class="col-12">
			<button ng-click="start_quiz()" type="button" class="btn btn-warning btn-block">
				<span class="oi oi-media-play mr-2"></span> Mulai
			</button>
		</div>		
	</div>
	
	<div ng-if="started == 2" class="col-12 mx-2">
		<div class="col-12" ng-if="judul">
			<h4 class="text-center">{{judul}}</h4>
			<hr />
		</div>
			
		<div ng-repeat="(key, item) in questions" ng-show="questions[{{key}}].show" class="col-12">
			<div ng-if="item.img_path" class="row">
				<img ng-src="{{item.img_path}}" class="img-fluid" />
			</div>
			
			<div ng-if="item.story_index != undefined" class="row">
				<div class="col-12 pl-5 pr-5 mb-3">
					<div class="col-12 pl-5 pr-5" ng-bind-html="arr_story[item.story_index] | toTrusted"></div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-12"><strong>{{key - 1000}})</strong> {{item.soal}}</div>
			</div>
			
			<div class="row">
				<div class="col-12 ml-3" ng-repeat="jawaban in item.jawaban">{{jawaban.choice}}. {{jawaban.label}}</div>
			</div>
			
			<div ng-if="item.post_soal" class="row">
				<div class="col-12"><br /><br />{{item.post_soal}}</div>
			</div>
		
			<div class="row mx-2 pt-4">
				<div class="col px-1" ng-repeat="jawaban in item.jawaban">
					<button ng-click="answer(item.id_soal, jawaban.id)" id="jawaban_soal_{{item.id_soal}}_{{jawaban.id}}" type="button" class="jawaban_soal_{{item.id_soal}} btn btn-outline-primary btn-block">{{jawaban.choice}}</button>
				</div>
			</div>
		</div>
		
		<div class="col-12 px-4 mt-2" ng-if="questions" ng-show="show_next_button">
			<button ng-class="has_next() ? '' : 'disabled'" ng-click="next_question()" class="btn btn-outline-success btn-block" type="button">
				Pertanyaan Berikutnya
				<span class="oi oi-chevron-right ml-3 t3"></span>
			</button>
		</div>
		
		<!--<div class="col-12 px-4 mt-2" ng-if="questions" ng-show="show_next_button">
			<button ng-class="has_prev() ? '' : 'disabled'" ng-click="prev_question()" type="button" class="btn {{btn_action_size}} btn-outline-default btn-block">
				<span class="oi oi-chevron-left mr-3 t3"></span>
				Pertanyaan Sebelumnya
			</button>
		</div>-->
		
		<div class="col px-4 mt-2" ng-if="skip_test">
			<button ng-click="finish()" class="btn {{btn_action_size}} btn-warning btn-block">
				Seluruh soal pada subtes ini sudah dikerjakan, lanjutkan ke subtes berikutnya
				<span class="oi oi-media-skip-forward mr-3 t3"></span>
			</button>
		</div>
	</div>
	
	<div class="col-12 mb-5">
		&nbsp;
	</div>
</div>
