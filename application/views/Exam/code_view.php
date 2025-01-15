<script>
	var forceExit = false;
	var QUESTIONS_URL = '<?php echo $get_questions_url;?>';
	var SAVEANSWER_URL = '<?php echo $save_answers_url;?>';
	var ARR_QUIZ = <?php echo json_encode($quiz_codes);?>;

	window.onbeforeunload = function(e) {
		if ($('#quiz_selesai').is(':visible')) {
			forceExit = true
		}
		
		/*
		if (forceExit == false) {
			var dialogText = 'Apakah Anda yakin akan meninggalkan halaman ini?';
			e.returnValue = dialogText;
			return dialogText;
		}
		*/
	};

	$(function(){
		$('#logout_button').data('override', 1);
		
		$('#logout_button').on('click', function(e){
			e.preventDefault();
			
			if ($('#quiz_selesai').is(':visible')) {
				forceExit = true
				$(this).data('override', 0)
				return;
			}
			
			var yes = confirm("Anda yakin mau logout ketika menjalankan test?\n\nKlik OK jika ingin meninggalkan test.");
			
			if (! yes) return false;
			
			forceExit = true
			$('#logout_button').data('override', 0);
		})
		
		$('#a_logo, #home_button').on('click', function(e){		
			
			if ($('#quiz_selesai').is(':visible')) {
				forceExit = true
				return;
			}
			
			var yes = confirm("Anda yakin mau meninggalkan test?\n\nKlik OK jika ingin meninggalkan test.");
			
			if (! yes) return false;
			
			forceExit = true
		})
	})	
		
	// Main Controller
	app.controller('main', ['$scope', '$interval', '$http', function($scope, $interval, $http) {
		$scope.just_log = function (){
			console.log("Just logging.");
		}
		$scope.saved_answer
		$scope.id = 0
		$scope.seconds = 0
		$scope.progress_max = 0
		$scope.progress_now = 0
		$scope.progress_percent = 0
		$scope.stop
		$scope.alldone = false
		$scope.main_quiz_title = '<?php echo $main_quiz_title;?>';
		$scope.main_quiz_code = '<?php echo $main_quiz_code;?>';
		$scope.quiz_codes = <?php echo json_encode($quiz_codes);?>;
		$scope.max_id = <?php echo count($quiz_codes);?> 
		$scope.get_questions_url = '<?php echo $get_questions_url;?>'
		$scope.save_answers_url = '<?php echo $save_answers_url;?>'
		$scope.save_index_url = '<?php echo $save_index_url;?>'
		$scope.petunjuk_button = false
		$scope.petunjuk_is_opened = false
		$scope.img_path = '<?php echo $img_path;?>'
		$scope.respawn = {}
		$scope.endofquiz = false
		$scope.seconds_extra = 0
		$scope.seconds_extra_active = false
		$scope.clientkey;
		$scope.alert_text = '';
		$scope.show_alert = false;
		$scope.controller_library = ''
		$scope.current_sub_library;
		
		$scope.quiz_stat = {}
		$scope.quiz_check_id = {}
		
		$scope.refresh_every = 10
		$scope.refresh_count = 0
		
		$scope.done_sent = false
		$scope.show_done_await = false
		
		var id_timeout = {}
		
		// Load respawn data
		try {
			$scope.respawn = JSON.parse(getCookie('respawn_'+clientUsername));
		}
		catch(err) {
			// ...
		}
		
		if (Object.keys($scope.respawn).length > 0) {
			setTimeout(function(){
				$scope.respawn_action()
			}, 1000)
		}
		else {
			$scope.alldone = true
		}
		
		$scope.respawn_action = function(){
			$.each($scope.respawn, function(library, codes){
				$.each(codes, function(code, arr_jawaban){
					if (Object.keys(arr_jawaban).length > 0) {
						if (getCookie(code+'_'+clientUsername) == 1)
							done = 1 // Kalau sudah ada cookie tetapi masih ada data yg belum dikirim, maka set sekalian done.
						else
							done = 0
						
						$scope.send_answer(library, code, false, arr_jawaban, done)
					}
					else {
						delete($scope.respawn[library][code])
						setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
						
						$scope.check_alldone()
					}
				})
				
				setTimeout(function(){
					$scope.check_alldone()
				}, 1000)
			})
		}
		
		$scope.timer_state = 'start'
		
		$scope.save_get_questions = function(code, stat, data) {
			console.log("Get question called.");
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				localStorage.setItem(code+'_'+stat+'_data', JSON.stringify(data));
			} else {
				// Sorry! No Web Storage support..
				return ''
			}
		}
		
		$scope.get_quiz_stat = function(code) {
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				return localStorage.getItem(code+'_stat');
			} else {
				// Sorry! No Web Storage support..
				return undefined
			}
		}
		
		$scope.set_quiz_stat = function(code, stat) {
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				localStorage.setItem(code+'_stat', stat);
			} else {
				// Sorry! No Web Storage support..
				return false
			}
		}
		
		$scope.get_quiz_last_index = function(code, stat) {
			
			if ($scope.quiz_stat[code] != null) {
				return parseInt($scope.quiz_stat[code])
			}
			
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				return parseInt(localStorage.getItem(code+'_'+stat+'_last_index'));
			} else {
				// Sorry! No Web Storage support..
				return undefined
			}
		}
		
		$scope.set_quiz_last_index = function(code, stat, last_index) {
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				localStorage.setItem(code+'_'+stat+'_last_index', last_index);
			} else {
				// Sorry! No Web Storage support..
				return false
			}
			
			$scope.save_index(code, 0, last_index)
		}
		
		$scope.load_get_questions = function(code, stat) {
			console.log("Load Get Question.");
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				return localStorage.getItem(code+'_'+stat+'_data');
			} else {
				// Sorry! No Web Storage support..
				return ''
			}
		}
		
		$scope.reset_storage = function(code) {
			
			// delete cookies
			deleteCookie(code+'_stop_timer')
		
			if (typeof(Storage) !== "undefined") {
				// Code for localStorage/sessionStorage.
				
				var arr = []; // Array to hold the keys
				
				// Iterate over localStorage and insert the keys that meet the condition into arr
				for (var i = 0; i < localStorage.length; i++){
					var key = localStorage.key(i)

					var regex = new RegExp('^'+code+'_')
					
					if (key.match(regex)) {
						arr.push(localStorage.key(i));
					}
				}

				// Iterate over arr and remove the items by key
				for (var i = 0; i < arr.length; i++) {
					localStorage.removeItem(arr[i]);
				}
			} else {
				// Sorry! No Web Storage support..
				return ''
			}
		}
		
		$scope.info = function(text, type) {
			span = $('<span></span>').html(text).addClass('badge badge-'+type)
			
			time = 'slow'
			if (type == 'warning') { 
				time = 3000
				// simpan waktu terakhir
				//setCookie($scope.quiz_codes[$scope.id].code+'_stop_timer', $scope.seconds)
				// pause timer
				//$scope.timer_state = 'pause'
			}
			else if (type == 'success') { 
				deleteCookie($scope.quiz_codes[$scope.id].code+'_stop_timer')
				$scope.timer_state = 'start'
			}
			else if (type == 'danger') {
				time = 5000
			}
			
			span.fadeOut(time)
			$('#badge-info').append(span)
		}
		
		$scope.load = function(library) {
			
			$scope.current_sub_library = null
			
			if ($scope.id >= $scope.max_id) {
				$scope.back_to_main_menu();
				return undefined;
			}
			
			if ($scope.quiz_codes[$scope.id].library == library) {
				
				$scope.controller_library = library
				
				if (getCookie($scope.quiz_codes[$scope.id].code+'_'+clientUsername) == 1) {
					
					$scope.reset_storage($scope.quiz_codes[$scope.id].code)
					
					if ($scope.max_id == 1) {
						$scope.back_to_main_menu();
					}
					else {
						$scope.id = $scope.id + 1
						$scope.$broadcast('reload');
					}
					
					return undefined;
				}
				
				if (Object.keys($scope.quiz_codes).length > 0)
					$scope.subtest = $scope.quiz_codes[$scope.id].label
				
				$scope.quiz_stat[$scope.quiz_codes[$scope.id].code] = $scope.quiz_codes[$scope.id].index
				
				if ($scope.quiz_codes[$scope.id].check_id != null) {
					setCookie($scope.quiz_codes[$scope.id].code+'_stop_timer', $scope.quiz_codes[$scope.id].check_id)
				}
				
				$scope.refresh_count = 0
				
				if ($scope.quiz_codes[$scope.id].sub_library) {
					$scope.current_sub_library = $scope.quiz_codes[$scope.id].sub_library
				}
				
				return $scope.quiz_codes[$scope.id].code
			}
		}
		
		$scope.next_quiz = function(library) {
			$scope.stop_timer()
			$scope.timer = ''
			$scope.id = $scope.id + 1

			if ($scope.id < $scope.max_id) {
				console.log('A')
				setCookie($scope.quiz_codes[$scope.id - 1].code+'_'+clientUsername, 1);
				$scope.reset_storage($scope.quiz_codes[$scope.id - 1].code)
				
				// Panggil method load di semua library untuk mengambil soal
				$scope.$broadcast('reload')
			}
			else {
				// Quiz sudah selesai semua, broadcast khusus untuk library terakhir
				if ($scope.quiz_codes[$scope.id - 1] != undefined)
					$scope.$broadcast('back_to_main_menu', { library: $scope.quiz_codes[$scope.id - 1].library })
			}
		}
		
		$scope.back_to_main_menu = function() {
			//alert('Semua test sudah selesai. Kembali ke halaman utama.')
			if ($scope.quiz_codes[$scope.id-1]) {
				console.log('B')
				setCookie($scope.quiz_codes[$scope.id-1].code+'_'+clientUsername, 1);
				$scope.reset_storage($scope.quiz_codes[$scope.id-1].code)
			}
			console.log('C')
			// ini tidak usah diset, biar dari halaman index yang mengeset saat check database
			//setCookie($scope.main_quiz_code+'_'+clientUsername, 1)
			$scope.reset_storage($scope.main_quiz_code)
			//window.location.href = '<?php echo $back_to_main_menu_url;?>'
			
			$scope.endofquiz = true
			
			// semua id_timeout yg masih tersisa, dibersihkan
			$.each(id_timeout, function(id, val){
				clearTimeout(id_timeout[id]);
				console.log('clear unfinished job-'+id)
			})
			
			setTimeout(function(){
				$scope.respawn_action()
			}, 2000)
		}
		
		$scope.check_alldone = function(){
			$scope.alldone = true
			
			$.each($scope.respawn, function(library, codes){
				if (Object.keys($scope.respawn[library]).length > 0) {
					//console.log(library+' = '+Object.keys($scope.respawn[library]).length)
					$.each($scope.respawn[library], function(code, items){
						//console.log(library+'-'+code+' = '+Object.keys($scope.respawn[library][code]).length)
						if (Object.keys($scope.respawn[library][code]).length > 0) {
							$scope.alldone = false
							//console.log('1. alldone: false')
						}
					})
				}
				else {
					delete($scope.respawn[library])
					setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
					
					$scope.stop_alldone = $interval(function(){
						//console.log('2. alldone: '+$scope.alldone)
						$interval.cancel($scope.stop_alldone);
					}, 1000)
				}
			})
		}
		
		$scope.check_seconds_left = function(seconds) {
			check_stop_timer = getCookie($scope.quiz_codes[$scope.id].code+'_stop_timer')
			
			if (check_stop_timer != '') {
				return check_stop_timer
			}
			
			return seconds
		}
		
		$scope.start_timer = function(seconds, seconds_extra) {
			
			$scope.seconds = seconds
			
			if ($scope.quiz_codes[$scope.id]) {
				check_stop_timer = getCookie($scope.quiz_codes[$scope.id].code+'_stop_timer')
			
				if (check_stop_timer != '') {
					$scope.seconds = check_stop_timer
					deleteCookie($scope.quiz_codes[$scope.id].code+'_stop_timer')
				}	
			}
			
			$scope.seconds_extra = seconds_extra == undefined ? 0 : seconds_extra
			$scope.progress_max = seconds
			$scope.progress_now = seconds
			
			$scope.timer = $scope.generate_timer($scope.seconds)
			$scope.seconds = $scope.seconds - 1
			
			$scope.stop = $interval(function(){
				
				if ($scope.refresh_count >= $scope.refresh_every) {
					var code = $scope.quiz_codes[$scope.id].code
					// $scope.save_index(code, 0, $scope.quiz_stat[code])
					$scope.refresh_count = 0
				}
				
				$scope.progress_now = $scope.seconds
				$scope.progress_percent = $scope.progress_now / $scope.progress_max * 100
				
				if ($scope.seconds < 0 && $scope.seconds_extra <= 0) {
					$scope.seconds_extra_active = false
					$interval.cancel($scope.stop);
					$scope.time_is_up()
				}
				else if ($scope.seconds < 0) {
					$scope.seconds = $scope.seconds_extra
					$scope.progress_max = $scope.seconds
					$scope.progress_now = $scope.seconds
					$scope.seconds_extra = 0
					$scope.seconds_extra_active = true
				}
				else {
					$scope.timer = $scope.generate_timer($scope.seconds)
					setCookie($scope.quiz_codes[$scope.id].code+'_stop_timer', $scope.seconds)
					
					if ($scope.timer_state == 'start')
						$scope.seconds = $scope.seconds - 1
				}
				
				$scope.refresh_count++
			}, 1000);
		}
		
		$scope.stop_timer = function() {
			if ($scope.stop)
				$interval.cancel($scope.stop)
		}
		
		$scope.force_stop_timer = function() {
			$interval.cancel($scope.stop);
		}
		
		$scope.generate_timer = function(seconds) {
			var hours = Math.floor(seconds/3600)
			var minutes = Math.floor((seconds - (hours * 3600))/60)
			var seconds = seconds - (hours * 3600) - (minutes * 60)
			
			if (hours == 0) hours = ''; else hours = hours + ':';
			if (hours < 10 && hours != '') hours = '0' + hours;
			if (minutes < 10) minutes = '0' + minutes;
			if (seconds < 10) seconds = '0' + seconds;
			
			return hours + minutes + ':' + seconds
		}
		
		$scope.write_respawn = function(library, code, id, answers, done){
			// respawn
			if ($scope.respawn[library] == undefined)
				$scope.respawn[library] = {}
			
			if ($scope.respawn[library][code] == undefined)
				$scope.respawn[library][code] = {}
			
			// Dikirim ulang kalau jawabannya berbeda dengan yg tersimpan
			if ($scope.respawn[library][code][id] != answers[id]) {
				$scope.respawn[library][code][id] = answers[id]
				
				setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
				
				$scope.alldone = false
				//console.log('3. alldone = false')
				
				id_timeout[id] = setTimeout(function(){
					$scope.send_answer(library, code, id, answers, done)
				}, 5000)
			}
			
			if (id == false || id == undefined) {
				setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
				
				$scope.alldone = false
				//console.log('4. alldone = false')
				
				id_timeout[id] = setTimeout(function(){
					$scope.send_answer(library, code, id, answers, done)
				}, 5000)
			}
		}
		
		$scope.save_index = function(code, tutorial, index) {
			var check_id = $scope.seconds

			$scope.quiz_stat[code] = index
			
			$http({
				url: $scope.save_index_url,
				method: 'post',
				data: $.param({code: code, index: index, tutorial: tutorial, check_id: check_id}),
				dataType: 'Json',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				if (response.data.error) {
					alert(response.data.msg)
				}
				else if (response.data.success) {
					
				}
				else {

				}
				
			}, function errorCallback(response) {
				if (response.xhrStatus) {
					
				}
			});
		}
		
		$scope.send_answer = function(library, code, id, answers, done) {
			var check_id = $scope.seconds
			var pesan = "Terdapat gangguan jaringan pada perangkat yang anda gunakan saat ini. Anda akan dialihkan ke halaman awal."		
			$http({
				url: $scope.save_answers_url,
				method: 'post',
				data: $.param({library: library, code: code, id: id, answers: answers, done: done, check_id: check_id}),
				dataType: 'Json',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				if (response.data.error) {
					$scope.info(response.data.msg, 'danger')
					
					if (done == 1) {
						$scope.write_respawn(library, code, id, answers, done)
					}
				}
				else if (response.data.success) {
					
					if (done == 1) {
						$scope.done_sent = true
						$scope.$broadcast('paulidone', {library: library, code: code})
					}
					
					$.each (answers, function(id, jawaban){
						if ($scope.respawn[library] == undefined)
							return;
							
						if ($scope.respawn[library][code] == undefined)
							return;
						
						if ($scope.respawn[library][code][id] != undefined) {
							delete($scope.respawn[library][code][id])
							setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
							clearTimeout(id_timeout[id])
							$scope.check_alldone()
						}
					})
					
					//$scope.info('Berhasil Dikirim', 'success')
				}
				else {
					$scope.write_respawn(library, code, id, answers, done)
					$scope.info('Koneksi Anda terganggu, sedang dikirim ulang', 'warning')
					alert(pesan)
					window.location = window.location.origin + '/exam'
				}
				
			}, function errorCallback(response) {
				if (response.xhrStatus) {
					$scope.write_respawn(library, code, id, answers, done)
					$scope.info('Koneksi Anda terganggu, sedang dikirim ulang', 'warning')
					alert(pesan)
					window.location = window.location.origin + '/exam'
				}
			});
			
			// Langsung scroll ke bawah biar kelihatan tombolnya
			$scope.saved_answer = undefined;
			$('html,body').animate({ scrollTop: 9999 }, 'slow');
		}
		
		$scope.done = function(library, code, answers) {
					
			if (answers != undefined)
				pool_answers = answers
			else if ($scope.respawn[library]) {
				pool_answers = $scope.respawn[library][code]
			}
			else {
				pool_answers = {}
			}
			
			var check_id = $scope.seconds
			
			// show loading
			$scope.show_done_await = true
			console.log("Quiz ini sudah selesai.")
			
			if ($scope.saved_answer != undefined){
				if ($scope.saved_answer.done != undefined){
					$scope.send_answer($scope.saved_answer.library,
							$scope.saved_answer.code,
							$scope.saved_answer.id,
							$scope.saved_answer.jawaban_data
							)
				} else {
					$scope.send_answer($scope.saved_answer.library,
							$scope.saved_answer.code,
							$scope.saved_answer.id,
							$scope.saved_answer.jawaban_data,
							$scope.saved_answer.done
							)
				}
			}
			
			$http({
				url: $scope.save_answers_url,
				method: 'post',
				data: $.param({key: $scope.clientkey, library: library, answers: pool_answers, code: code, done: 1, check_id: check_id}),
				dataType: 'Json',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).then(function successCallback(response) {
				if (response.data.error) {
					//alert(response.data.msg)
					$scope.info(response.data.msg, 'danger')
					$scope.write_respawn(library, code, false, pool_answers, 1)
					$scope.alldone = false
					//console.log('5. alldone = false')
				}
				else if (response.data.success) {
					$.each(pool_answers, function(id, val){
						if ($scope.respawn[library] != undefined)
							delete($scope.respawn[library][code][id])
						
						setCookie('respawn_'+clientUsername, JSON.stringify($scope.respawn));
						clearTimeout(id_timeout[id])
					})
					
					$scope.done_sent = true
					$scope.alldone = true
					$scope.$broadcast('paulidone', {library: library, code: code})
				}
				else {
					$scope.write_respawn(library, code, false, pool_answers, 1)
					$scope.alldone = false
					//console.log('6. alldone = false')
				}
			}, function errorCallback(response) {
				
				$scope.alldone = false
				//console.log('7. alldone = false')
				$scope.info(response.statusText, 'danger')
				
				// respwan setiap 20 detik
				setTimeout(function(){
					$scope.done(library, code, pool_answers)
				}, 20000)
			});
		}
		
		$scope.show_petunjuk = function(stat) {
			if (stat) {
				$scope.petunjuk_button = true
			}
			else {
				$scope.petunjuk_button = false
			}
		}
		
		$scope.toggle_petunjuk = function() {
			if ($scope.petunjuk_is_opened == false) {
				$scope.$broadcast('buka_petunjuk')
				$scope.petunjuk_is_opened = true
			}
			else {
				$scope.$broadcast('tutup_petunjuk')
				$scope.petunjuk_is_opened = false
			}
		}
		
		$scope.time_is_up = function() {
			//alert('Waktu sudah habis. Akan dilanjutkan ke test berikutnya.')
			$scope.alert_text = 'Waktu pengerjaan untuk '+ $scope.quiz_codes[$scope.id].label +' sudah habis. Akan dilanjutkan ke test berikutnya.';
			//$scope.show_alert = true;
			
			$scope.$broadcast('time_is_up', { library: $scope.quiz_codes[$scope.id].library, code:  $scope.quiz_codes[$scope.id].code })
		}
		
		$scope.close_alert = function() {
			$scope.alert_text = ''
			$scope.show_alert = false
			$scope.done_sent = false
			$scope.show_done_await = false
			
			$scope.next_quiz()
		}
		
		if ($scope.quiz_codes.length == 0) {
			$scope.back_to_main_menu()
		}
		
		$scope.total_loaded = {}
		
		$scope.image_loaded = function(code, index, custom_total) {
			var total = 6
			
			if (custom_total != undefined) {
				total = custom_total
			}
			
			if ($scope.total_loaded[code] == undefined) {
				$scope.total_loaded[code] = {}
			}
			
			if ($scope.total_loaded[code][index] == undefined) {
				$scope.total_loaded[code][index] = 0
			}
			
			$scope.total_loaded[code][index] += 1
			
			//console.log('code: '+code+', load index: '+index+', image ke-'+$scope.total_loaded[code][index])
			
			if ($scope.total_loaded[code][index] >= total) {
				deleteCookie(code+'_stop_timer')
				// start timer
				$scope.timer_state = 'start'
			}
		}
	}])

	app.directive('imageonload', function() {
		return {
			restrict: 'A',
			link: function(scope, element, attrs) {
				element.bind('load', function() {
					//call the function that was passed
					scope.$apply(attrs.imageonload);
				});
			}
		};
	})
</script>

<style>
.alert_dialog {
	position: fixed;
	top: 0;	left: 0;
	z-index: 1025;
	width: 100%; height: 100%;
	background-color: rgba(255,255,255,0.9);
}
</style>

<div ng-if="show_alert == true" class="alert_dialog" ng-cloak>
	<table width="100%" height="100%">
		<tbody><tr>
			<td align="center">
				<div class="row">
					<div class="col">
						<p>{{alert_text}}</p>
					</div>
				</div>
				<div class="row mx-2">
					<div class="col-lg-2 offset-lg-5 col-sm-8">
						<button ng-click="close_alert()" class="btn btn-primary btn-block" type="button">OK</button>
					</div>
				</div>
			</td>
		</tr></tbody>
	</table>
</div>

<div ng-if="show_done_await == true" class="alert_dialog" ng-cloak>
	<table width="100%" height="100%">
		<tbody>
			<tr>
				<td align="center">
					<div class="row">
						<div class="col">
							<p ng-if="alert_text != ''">{{alert_text}}</p>
							<p>Sedang menutup test '{{quiz_codes[id].label}}'.
							<span ng-if="done_sent == false"> Silahkan tunggu sampai muncul tombol OK.</span>
							<span ng-if="done_sent == true && quiz_codes[id].code == 'english'"> Berhasil. <br />Silakan tekan tombol OK untuk mengakhiri keseluruhan tes online..</span>
							<span ng-if="done_sent == true && quiz_codes[id].code != 'english'"> Berhasil. <br />Silahkan tekan tombol OK untuk melanjutkan.</span>
							</p>
						</div>
					</div>
					<div class="row mx-2">
						<div class="col-lg-2 offset-lg-5 col-sm-8">
							<img ng-src="<?php echo base_url('assets/images/pauli/loading.gif');?>" ng-if="done_sent == false" />
							<button ng-if="done_sent == true" ng-click="close_alert()" class="btn btn-primary btn-block" type="button">OK</button>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div ng-if="endofquiz" class="card" ng-cloak>
	<div class="card-body">
		<h5 class="card-title">
			<strong>Terima kasih sudah mengerjakan Tes Online</strong>
		</h5>
		<div class="card-text">
			<p ng-if="! alldone">
				<em>Masih mengirim jawaban yang belum tersimpan&hellip;</em>
			</p>
			<p ng-if="alldone" id="quiz_selesai">
				Semoga sukses untuk Anda!
			</p>
			<?php /*
			<p>Silahkan klik tombol <strong>Kembali ke Home</strong> untuk mengerjakan tes berikutnya, jika masih ada tes yang belum Anda kerjakan.</p>
			<p ng-if="! alldone">
				<em>Masih mengirim jawaban yang belum tersimpan&hellip;</em>
			</p>
			<p ng-if="alldone">
				<a onclick="forceExit = true;" class="btn btn-primary" href="<?php echo $back_to_main_menu_url;?>">Kembali ke Home</a>
			</p>
			*/;?>
		</div>
	</div>
</div>

<!-- Controller langsung diload di sini -->
<div ng-cloak>	
	<!-- Controllernya ada di tiap-tiap library -->
	<?php foreach ($library_views as $view):?>
	<?php echo $view;?>
	<?php endforeach;?>
</div>
