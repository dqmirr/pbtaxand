<style>
	.block_ui {
		position: fixed;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background: rgba(255,255,255,0.9);
		z-index: 3000;
	}

	.block_ui .modal-center {
		margin: auto;
		height: 100%;
	}

	.block_ui .modal-center .block-content {
		background: #4D4D4D;
		border: 1px solid #000000;
		box-shadow: 1px 1px 5px rgba(0,0,0,0.3);
		padding: 10px;
		border-radius: 7px;
		color: #FFF;
	}

	.btn-outline-success{
		background-color:var(--light)
	}

	#petunjuk{
		background-color: var(--light);
		padding: 0 2rem;
		border-radius: 1rem;
	}

	#main .panel-soal{
		padding: 1rem;
		margin-top: 2rem;
		background-color: var(--light);
		border-radius: 1rem;
		margin-bottom: 1rem;
	}
	.btn-outline-primary{
		background-color: var(--light)
	}
</style>

<script>
var questions = [];
var quiz_index = 0;
var quiz = <?php echo json_encode($quiz_data);?>;
var epoch_start = 0;
var timer;
var timer_seconds;
var timer_seconds_run = null;
var timer_extra_seconds;
var timer_extra_seconds_run = 0;
var timer_used = 0;
var time_start = null;
var total_seconds = null;
var index = 0;
var max_index = 0;
var set_soal;
var is_tutorial = 1;
var has_tutorial;
var quiz_data = null;
var arr_story = null;
var group_code = null;
var jawaban_belum_terkirim = {};
var done = 0;
var timer_ui = $('#timer_container > span')
var timer_progress_ui = $('#timer_container .progress-bar')
var is_start = false;

String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    // hanya tampilkan hours jika lebih dari 1 jam
    if (hours > 0) {
        if (hours   < 10) {hours   = "0"+hours;}
    }
    
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    
    if (hours > 0) {
        text = hours+':'+minutes+':'+seconds;
    }
    else {
        text = minutes+':'+seconds;
    }
    
    return text;
}

var clear_from_storage = function() {
    delete_from_local('index')
    delete_from_local('done')
    delete_from_local('jawaban_belum_terkirim')
    delete_from_local('quiz_data')
    delete_from_local('arr_story')
    delete_from_local('timer_seconds')
    delete_from_local('timer_extra_seconds')
    delete_from_local('timer_used')
    delete_from_local('validation')
    delete_from_local('group_code')
}

var delete_from_local = function(name) {
    var storage_type = 'cookie'
    
    if (name == 'quiz_data') {
        storage_type = 'local_storage'
    }
    
    var cname = quiz.code + '_' + name
    
    if (storage_type == 'cookie') {
        document.cookie = cname + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
    }
    else { // local storage
        localStorage.removeItem(cname);
    }
}

var finish = function() {
    done = 1
    save_to_local('done', done)
    kirim_jawaban()
}

function load_multiplechoice(data){
	// untuk multiplechoice

	if (data.rows && max_index > 0) {
		// Set Data to UI
		quiz_data = data.rows
		// Kalau test (bukan tutorial) maka langsung set soal dan mulai timer
		if (is_start) {
			// simpan rows
			if (data.arr_story) {
				arr_story = data.arr_story
				save_to_local('arr_story', arr_story) 
			}

			save_to_local('quiz_data', quiz_data)
			save_to_local('validation', data.validation)
			
			$('#main').show()
			index = data.index
			set_soal()
			
			// Set timer
			let timer_used = get_timer_used()
			console.log('load_multiplayer', data)
			if(!data.total_seconds){
				return;
			}
			timer_set(data.total_seconds, timer_used, data.seconds_extra)
			
			// Show time ui
			timer_ui.parent().removeAttr('ng-cloak')
			timer_ui.text('')
			
			// Start timer
			timer_start()
		}
	}
}

function load_ist(data){
	// untuk ist
	if (data.group_code) {
		group_code = data.group_code
		save_to_local('group_code', group_code)
	}

	if (data.rows && max_index > 0) {
		// Set Data to UI
		quiz_data = data.rows
		// Kalau test (bukan tutorial) maka langsung set soal dan mulai timer
		if (!is_tutorial) {
			// simpan rows
			save_to_local('quiz_data', quiz_data)
			save_to_local('validation', data.validation)
			
			$('#main').show()
			index = data.index
			set_soal()
			
			// Set timer
			let timer_used = get_timer_used()
			console.log('load_ist', data)
			if(!data.total_seconds){
				return;
			}
			timer_set(data.total_seconds, timer_used, data.seconds_extra)
			
			// Show time ui
			timer_ui.parent().removeAttr('ng-cloak')
			timer_ui.text('')
			
			// Start timer
			timer_start()
		}
	}
}

function load_default(data){
	if (data.group_code) {
		group_code = data.group_code
		save_to_local('group_code', group_code)
	}

	if (data.rows && max_index > 0) {
		// Set Data to UI
		quiz_data = data.rows
		// Kalau test (bukan tutorial) maka langsung set soal dan mulai timer
		if (!is_tutorial) {
			// simpan rows
			save_to_local('quiz_data', quiz_data)
			save_to_local('validation', data.validation)
			
			$('#main').show()
			index = data.index
			set_soal()
			
			// Set timer
			let timer_used = get_timer_used()
			if(!data.total_seconds){
				return;
			}
			timer_set(data.total_seconds, timer_used, data.seconds_extra)
			
			// Show time ui
			timer_ui.parent().removeAttr('ng-cloak')
			timer_ui.text('')
			
			// Start timer
			timer_start()
		}
	}
}

var get_data_from_server = function() {
	let now = new Date()
    $.ajax({
        beforeSend: function() {
            $('#button_loader').parent().show()
        },
        data: {'code': quiz.code, 'library': quiz.library, 'tutorial': is_tutorial, 'epoch_now': now.getTime()},
        dataType: 'json',
        error: function(jqXHR,textStatus,errorThrown) {
            $('#button_loader').parent().hide()
            show_retry_button()
        },
        success: function(data) {
            $('#button_loader').parent().hide()

			clear_from_storage();
            
            if (! data.success) {
                show_retry_button()
                return;
			}

			if(data.hasOwnProperty('time_start') && data.time_start != null){
				time_start = data.time_start;
			}
			if(data.hasOwnProperty('epoch_start') && data.total_seconds != null){
				total_seconds = data.total_seconds;
			}

			if(data.hasOwnProperty('epoch_start') && data.epoch_start != null){
				epoch_start = +data.epoch_start;
			}

			if(data.hasOwnProperty('index') && data.index != 0){
				// is_tutorial = 0;
				// is_start = true;
				from_server_index = parseInt(data.index) +1
				save_to_local('index', from_server_index)
				data.index = from_server_index
			}

			
            if (is_tutorial) {
                if (data.rows && data.rows.length > 0) {
                    has_tutorial = true
                    show_tutorial_button()
                    questions = data.rows
                }
                else {
                    is_tutorial = 0
                    show_test_button()
                }
            }
            
            if (data.rows.length === undefined) {
                // Ini untuk multiplechoice
                max_index = 1001 + Object.keys(data.rows).length;
            }
            else {
                max_index = data.rows.length
            }
			switch(quiz.library){
				case 'multiplechoice':
					load_multiplechoice(data);
					break;
				case 'ist':
					load_ist(data);
					break;
				default: 
					load_default(data);
					break;
			}
        
        },
        type: 'POST',
        url: '<?php echo $get_questions_url;?>'
    })
}

var hide_next_button = function() {
    $('#next_button').parent().hide()
}

var jawaban_benar = function() {
    $('#benar_salah > div').hide()
    $('#benar_salah > div:eq(1)').show()
    show_next_button()

    /* 
    * Kalau index kurang dari max_index minus 1, maka jangan tampilkan tombol pertanyaan selanjutnya,
    * tapi tampilkan tombol mulau quiz atau ulangi tutorial
    */
    if (index >= (max_index - 1)) {
        show_test_button()
        $('html, body').animate({scrollTop: parseInt($('#start_test_button').offset().top)}, 0);
    }
}

var jawaban_salah = function() {
    $('#benar_salah > div').hide()
    $('#benar_salah > div:eq(0)').show()
    $('#next_button').parent().hide()
}

var kirim_jawaban = function() {
    var answers = load_from_local('jawaban_belum_terkirim')
    var used = load_from_local('timer_used', 0)
    
	// Kirim jawaban ke server
	$.ajax({
		beforeSend: function() {
			// Jika done = 1 (menutup quiz) maka blocking layar
			if (done == 1) {
				$('#block_ui').show()
			}
		},
		data: {library: quiz.library, code: quiz.code, answers: answers, index: index, done: done, used: used},
		dataType: 'json',
		error: function() {
			if (done == 1) {
				console.log('Restarting kirim_jawaban in 5 seconds...')
				
				// restart in 5 seconds
				setTimeout(kirim_jawaban, 5000)
			}
			else {
				/* Alert error karena koneksi */
				// alert('Terjadi gangguan koneksi. Silahkan coba beberapa saat lagi.')
				
				timer_pause(true)  
				$('#next_button').prop('disabled', false)
			}
		},
		success: function(data) {
			simpan_jawaban_sudah_terkirim(answers) 
			if(! data.success) {
				if (done == 1) {
					// restart in 5 seconds
					setTimeout(kirim_jawaban, 5000)
				}
				else {
					$('#next_button').prop('disabled', false)
				}
				
				if (data.redirect) {
					alert(data.msg)
				}
			}
			else {
				// Hapus dulu jawaban_belum_terkirim sesuai dengan data di variable answers
				jawaban_belum_terkirim = load_from_local('jawaban_belum_terkirim')
				
				$.each(answers, function(k,v) {
					if (jawaban_belum_terkirim[k]) {
						delete jawaban_belum_terkirim[k]
					}
				})
				
				// Simpan lagi
				save_to_local('jawaban_belum_terkirim', jawaban_belum_terkirim)
				if (done == 1) {
					// Hapus data
					clear_from_storage()
					
					// Reload halaman ini
					location.reload(); 
				}
				else {
					$('#next_button').prop('disabled', false)
					$('#next_button').parent().hide()
				}
				
				if (index < max_index) {
					index = parseInt(index) + 1
					set_soal()
				}
				
				// Simpan index
				save_to_local('index', index)
				
				// Unpause
				timer_pause(false)
			}
		},
		type: 'POST', 
		url: '<?php echo $save_answers_url;?>'
	})
}

var load_from_local = function(name, default_value) {
    var storage_type = 'cookie'
    
    if (name == 'quiz_data' || name == 'arr_story' || name == 'group_code') {
        storage_type = 'local_storage'
    }
    
    var cname = quiz.code + '_' + name
    
    if (storage_type == 'cookie') {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return JSON.parse(c.substring(name.length, c.length));
            }
        }
    }
    else { // local_storage
        if (window.localStorage!==undefined) {
            result = localStorage.getItem(cname)
            return JSON.parse(result)
        }
    }
    
    if (default_value !== undefined)
        return default_value
    
    return null;
}

var pertanyaan_selanjutnya = function() {
    
    $('#next_button').prop('disabled', false)
    
    if (! is_tutorial) {
        $('#next_button').prop('disabled', true)
        
        kirim_jawaban()
    }
    else {
        if (index < max_index) {
            index = parseInt(index) + 1
            set_soal()
        }
      
        $('#next_button').parent().hide()
        $('#benar_salah > div').hide()
    }
}

var retry_load_data = function() {
    get_data_from_server();
}

var save_to_local = function(name, value) {
    var storage_type = 'cookie'
    
    if (name == 'quiz_data' || name == 'arr_story' || name == 'group_code' || name == 'jawaban_sudah_terkirim') {
        storage_type = 'local_storage'
    }
    
    var cname = quiz.code + '_' + name
    var cvalue = JSON.stringify(value)
    
    if (storage_type == 'cookie') {
        var d = new Date();
        d.setTime(d.getTime() + (1*3*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }
    else { // local_storage
        if (window.localStorage!==undefined) {
            localStorage.setItem(cname, cvalue);
        }
    }
}

var show_finish_button = function() {
    $('#finish_button').parent().show()
}

var show_petunjuk = function() {
    $('#petunjuk').slideToggle()
}

var show_next_button = function() {
    var target_button = '#next_button'
    
    if (index >= (max_index - 1)) {
        if (is_tutorial) {
            target_button = '#start_test_button'
        }
        else {
            show_finish_button()
            target_button = '#finish_button'
        }
    }
    else {
        $('#next_button').parent().show()
    }
    
    $('html, body').animate({scrollTop: parseInt($(target_button).offset().top)}, 0);
}

var show_tutorial_button = function() {
    $('#start_tutorial_button').parent().show()
    $('#start_test_button').parent().hide()
    $('#retry_button').parent().hide()
    // $('[ng-if="petunjuk_button"]').hide()
	$('#btn_petunjuk').hide()
    $('#benar_salah').show()
}

var show_test_button = function() {
    $('#start_tutorial_button').parent().hide()
    $('#start_test_button').parent().show()
    $('#retry_button').parent().hide()
    $('#next_button').parent().hide()
    // $('[ng-if="petunjuk_button"]').show()
	// $('#btn_petunjuk').show()
    
    if (has_tutorial) {
        $('#ulangi_tutorial_button').parent().show()
    }
}

var show_retry_button = function() {
    $('#start_tutorial_button').parent().hide()
    $('#start_test_button').parent().hide()
    $('#retry_button').parent().hide()
}

var simpan_jawaban_sudah_terkirim = function(answers){
	// load from local
    jawaban_sudah_terkirim = load_from_local('jawaban_sudah_terkirim', {})
    
    // update jawaban
    jawaban_sudah_terkirim = { ...jawaban_sudah_terkirim, ...answers}
    // simpan ke local
    save_to_local('jawaban_sudah_terkirim', jawaban_sudah_terkirim)
}

var simpan_jawaban = function(id, jawaban) {
    if ($('#main').data('paused') == 1) {
        return;
    }
    
    // load from local
    jawaban_belum_terkirim = load_from_local('jawaban_belum_terkirim', {})
    
    // update jawaban
    jawaban_belum_terkirim[id] = jawaban
    // simpan ke local
    save_to_local('jawaban_belum_terkirim', jawaban_belum_terkirim)
    
    // tampilkan tombol pertanyaan selanjutnya
    show_next_button()
}

var start_tutorial = function() {
    $('#petunjuk').hide()
	$('#btn_petunjuk').show()
    $('#start_tutorial_button').parent().hide()
    $('#start_test_button').parent().hide()
    $('#ulangi_tutorial_button').parent().hide()
    $('#benar_salah > div').hide()
    $('#main').show()
    
    index = 0
    set_soal()

	$('#info_tutorial').show().html("<h4>TUTORIAL</h4>")
}

var start_test = function(load_from_local) {
    $('#petunjuk').hide()
    $('#ulangi_tutorial_button').parent().hide()
    // $('[ng-if="petunjuk_button"]').show()
	$('#btn_petunjuk').show()
    $('#start_test_button').parent().hide()
    $('#benar_salah, #benar_salah > div').hide()
    $('#main').hide()
    
    is_tutorial = 0
	is_start = true

	let is_load_from_local = load_from_local == 'load_from_local'
	console.log('is_load_from_local ', is_load_from_local)

	$('#info_tutorial').hide()
    if (load_from_local == 'load_from_local') {
        // langsung tampilkan main ui
        $('#main').show()
        
        // Show time ui
        timer_ui.parent().removeAttr('ng-cloak')
        timer_ui.text('')
        
        // Start timer
        timer_start()
    }
    else {
        get_data_from_server()
    }
}

function next_test_to_done(){
	const used = timer_used;
	$.ajax({
		beforeSend: function() {
			// Jika done = 1 (menutup quiz) maka blocking layar
			if (done == 1) {
				$('#block_ui').show()
			}
		},
		data: {code: quiz.code, used: used},
		dataType: 'json',
		error: function() {
			console.log("need error handling next test to done")
		},
		success: function(data) {
			if (data.hasOwnProperty('success') && data.success == true) {
				clear_from_storage()
				
				// Reload halaman ini
				location.reload();
            }
		},
		type: 'POST', 
		url: '<?php echo $ajax_next_test_to_done_url;?>'
	})
}

var show_panel_waktu_habis = function () {
	$('#petunjuk').hide()
	$('#main').show();
	let html = `
		<div class="container bg-white py-4 px-2">
			<center>
				<h1>Waktu Ujian Sudah Habis</h1>
				<p>Apakah Anda Ingin Melanjukan Ujian</p>
				<button onclick="next_test_to_done()" type="button" class="btn btn-primary">Lanjut Ujian</button>
			</center>
		</div>
	`
	$('#main').html(html)
}

var get_timer_used = function() {
	if(epoch_start){
		const epoch_seconds = epoch_start / 1000;
		let start_date_js = new Date(epoch_start)
		// start_date_js.setUTCSeconds(epoch_seconds)
		let now = new Date(Date.now())
		// console.log("now epoch", now.getTime())
		let timer_used = Math.ceil((now.getTime() - start_date_js.getTime()) / 1000); 
		if(timer_used >= total_seconds){
			return total_seconds;
		}
		return timer_used;
	}

	return 0;
}

var timer_set = function(total_seconds, timer_used, extra_seconds) {
    timer_seconds = parseInt(total_seconds)
    timer_seconds_run = parseInt(total_seconds - timer_used)
    timer_extra_seconds = parseInt(extra_seconds)
    timer_extra_seconds_run = parseInt(extra_seconds)
    
    save_to_local('timer_seconds', timer_seconds)
    save_to_local('timer_extra_seconds', timer_extra_seconds)
}

var timer_pause = function(stop) {
    if (stop === false) {
        $('#opsi_container, #soal_container, #jawaban_container').find('button').prop('disabled', false)
        $('#main').data('paused', 0)
        
        if (timer_seconds_run > 0) {
          timer_seconds_run++
        }
        else if (timer_extra_seconds_run > 0) {
          timer_extra_seconds_run++
        }
        
        timer_start()
    }
    else {
        clearInterval(timer)
        timer = null
        $('#opsi_container, #jawaban_container').find('button').prop('disabled', true)
        $('#main').data('paused', 1)
    }
}

var timer_start = function() {
	clearInterval(timer)
	var updateTimer=function(){
		// Timer normal
		if (timer_seconds_run > 0 ) {
			percentage = (timer_seconds_run / timer_seconds * 100)
		
			if(total_seconds){
				timer_seconds_run = total_seconds - get_timer_used()
			} else {
				timer_seconds_run -= 1
			}
			// Update ui timer
			timer_text = timer_seconds_run.toString().toHHMMSS()
			timer_ui.text(timer_text)
			
			// Update ui progress bar
			timer_progress_ui.css('width', percentage+'%')
			// save_to_local('timer_used', (timer_seconds - timer_seconds_run))
			save_to_local('timer_used', timer_used)
		}
		// Kalau punya extra_seconds maka masuk ke sini
		else if (timer_extra_seconds_run > 0) {
			percentage = (timer_extra_seconds_run / timer_extra_seconds * 100)
			timer_extra_seconds_run -= 1
			
			// Update ui timer
			timer_text = timer_extra_seconds_run.toString().toHHMMSS()
			timer_ui.text(timer_text).addClass('text-danger')
			
			// Update ui progress bar
			timer_progress_ui.addClass('bg-danger')
			timer_progress_ui.css('width', percentage+'%')
			
			save_to_local('timer_extra_seconds', timer_extra_seconds_run)
		}
		// Semua timer normal dan extra sudah habis
		else {
			if (timer) {
				clearInterval(timer)
			}
			
			// done = 1
			// save_to_local('done', done)
			// kirim_jawaban()
			show_panel_waktu_habis()
	
			return;
		}
	}
    
    timer = setInterval(updateTimer, 1000)
}

var timer_unpause_watch = function(total_image, total_loaded) {
    if (typeof total_image !== 'number' || typeof total_loaded !== 'number') {
        return;
    }
    
    total_loaded += 1
    
    if (total_loaded >= total_image) {
        timer_pause(false)
    }
    else {
        timer_pause()
    }
    
    return total_loaded
}

var ulangi_tutorial = function() {
    index = 0
    set_soal()
}

$(function() {
    // Beri peringatan kalau mau logout tapi masih di dalam test
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

$(function() {
    $('#start_tutorial_button').on('click', start_tutorial)
    // $('[ng-if="petunjuk_button"]').on('click', show_petunjuk)
    $('#btn_petunjuk').on('click', show_petunjuk)
    $('#retry_button').on('click', retry_load_data)
    $('#next_button').on('click', pertanyaan_selanjutnya)
    $('#ulangi_tutorial_button').on('click', start_tutorial)
    $('#start_test_button').on('click', start_test)
    $('#finish_button').on('click', finish)
    
    // Kalau ada quiz baru diperiksa, kalau null berarti quiz ini sudah selesai
    if (quiz !== null) {
        // Seting nama
        var subtest_text = $('[ng-if="subtest"]')
        subtest_text.text(quiz.label)
        subtest_text.removeAttr('ng-cloak')
        
        // Coba ambil dulu dari storage
        var validation = load_from_local('validation')
        quiz_data = load_from_local('quiz_data')
        arr_story = load_from_local('arr_story')
        group_code = load_from_local('group_code')
        done = load_from_local('done', 0)

		if(quiz && quiz.time_start){
			time_start = quiz.time_start
		}
		
		if(quiz && quiz.total_seconds){
			total_seconds = +quiz.total_seconds
		}
		if(quiz.hasOwnProperty('epoch_start') && quiz.epoch_start != null){
			epoch_start = +quiz.epoch_start
		}

		// menyamaakan timer_used client dengan realtime dari waktu start test
		if(timer_used != get_timer_used()){
			timer_used = get_timer_used()
		}

		//commpare timer_used di storage jika tidak sama maka timer_used di storage di update 
		if(timer_used !=parseInt(load_from_local('timer_used', 0))){
			save_to_local('timer_used', timer_used)
		}
		console.log(quiz)
		console.log("total_seconds", total_seconds);
		console.log("time_start", time_start);
		console.log("timer_used", timer_used);
		console.log("epoch_start", epoch_start);
		
		if(timer_used === total_seconds){
			show_panel_waktu_habis()
			return;
		}

        
        // Kalau quiz.validation ada datanya berati ini sudah ada quiz, dan time start nya belum ada maka langsung start_test()
        if (quiz.validation !== null && (quiz_data == null && time_start != null)) {
            start_test()
            return
        }
        else if (quiz.validation === null || load_from_local('timer_seconds') === null) {
            clear_from_storage()
        }
        
        // Kalau tidak ada quiz_data atau validationnya berbeda antara yang di storage dan dari server
        // maka hapus yang ada di storage dan ulang dari awal
        if (quiz_data === null || validation != quiz.validation) {
            // Hapus from storage
            clear_from_storage()
            
            // Belum ada datanya di storage
            get_data_from_server();
        }
        else {            
            index = load_from_local('index', 0)
            timer_seconds = parseInt(load_from_local('timer_seconds'))
			
            if (isNaN(timer_seconds)) {
                // Hapus from storage
                clear_from_storage()
                
                return false;
            }
            
            timer_seconds_run = timer_seconds - parseInt(load_from_local('timer_used', 0))
            timer_extra_seconds = parseInt(load_from_local('timer_extra_seconds', 0))
            timer_extra_seconds_run = parseInt(timer_extra_seconds)
            
            if (timer_seconds_run > 0) {
              timer_seconds_run = timer_seconds_run + 1
            }
            
            if (timer_extra_seconds_run > 0) {
              timer_extra_seconds_run = timer_extra_seconds_run + 1
            }
            
            if (quiz_data.length === undefined) {
                // untuk multiplechoice
                max_index = 1001 + Object.keys(quiz_data).length;
            }
            else {
                max_index = quiz_data.length
            }
            
            // Start
            start_test('load_from_local')
            set_soal()
        }
    }
})

</script>

<div class="container">
	<div class="row d-flex justify-content-center">

		<div class="col">
			<?php if(isset($quiz_setting['is_show_quiz_label'])): ?>
					<?php if($quiz_setting['is_show_quiz_label'] == true):?>

			<div class="row">
				<div class="col m-2">
					<div class="bg-light" style="border-radius:1rem; padding: 0.5rem;">
						<h4 class="text-center"><?=$quiz_data["label"]; ?></h4>
					</div>
				</div>
			</div>

					<?php endif; ?>
			<?php endif; ?>
			<div class="row">
				<div class="col m-2">
					
				</div>
			</div>
		</div>
		
		<div class="col-12">
			<div class=" yt-2 pb-5" style="height: 75vh; overflow-y:auto; margin-top: auto;">
				<div class="row m-2">
					<div class="col-2">
						<button class="btn btn-outline-primary mb-2" id="btn_petunjuk" style="display:none;">Petunjuk</button>
					</div>
					<div class="col-10">
					<div id="info_tutorial" class="bg-light text-center" style="display:none;border-radius:1rem; padding: 0.5rem;"></div>
					</div>
					<div class="col-12" style="width: 100%; height: 50vh;overflow:auto;">
						<?php echo $library_view;?>
					</div>
				</div>

				<div class="row mt-3" id="benar_salah" style="display: none">
					<div class="col" style="display: none">
						<div class="alert alert-danger text-center">
							Jawaban Salah
						</div>
					</div>
					<div class="col" style="display: none">
						<div class="alert alert-success text-center">
							Jawaban Benar
						</div>
					</div>
				</div>

				<div class="row mx-3 text-center my-4">
					<div class="col" style="display: none;">
						<button type="button" class="btn btn-outline-success btn-block" id="next_button">
							Pertanyaan Selanjutnya
						</button>
					</div>
					<div class="col" style="display: none;">
						<button type="button" class="btn btn-warning btn-block" id="finish_button">
							Simpan jawaban dan menutup quiz.
						</button>
					</div>
					<div class="col" style="display: none;">
						<button class="btn btn-primary btn-block" id="start_tutorial_button">
							Mulai Tutorial
						</button>
					</div>
					<div class="col" style="display: none;">
						<button class="btn btn-primary btn-block" id="ulangi_tutorial_button">
							Ulangi Tutorial
						</button>
					</div>
					<div class="col" style="display: none;">
						<button class="btn btn-warning btn-block" id="start_test_button">
							Mulai Test
						</button>
					</div>
					<div class="col" style="display: none;">
						<button class="btn btn-info btn-block" id="retry_button">
							Retry
						</button>
					</div>
					<div class="col" style="display: none;">
						<img src="<?php echo base_url('assets/images/loading.gif');?>" id="button_loader" />
					</div>
				</div>

				<div id="block_ui" class="block_ui" style="display: none;background-color: #ffffff80; padding: 1rem;">
					<table class="modal-center">
						<tbody>
							<tr>
								<td>
									<div class="block-content text-center">
										Sedang mengirim jawaban. Silahkan tunggu.
										<br />
										<img src="<?php echo base_url('assets/images/loading.gif');?>" />
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- <div class="col-4 px-2 display-none">
			<div class="card-transparent p-2 d-flex flex-wrap list-soal-number justify-content-center"></div>
		</div> -->
	</div>
</div>
