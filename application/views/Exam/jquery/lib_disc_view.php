<style>
	.table input[type="radio"] {
		-ms-transform: scale(2); /* IE 9 */
		-webkit-transform: scale(2); /* Chrome, Safari, Opera */
		transform: scale(2);
	}
</style>
<div id="petunjuk">
    <div class="row">
        <div class="col">
            <?php if ($code == 'disc1'):?>
            <p>Berikut ini adalah petunjuk pengisian kuesioner:</p>
            <ol>
							<li>Saat mengerjakan, bayangkan Anda berada dalam situasi kerja. </li>
							<li>Dalam setiap persoalan terdapat 4 (empat) pernyataan.</li>
							<li>Tugas Anda adalah memilih 1 (satu) pernyataan yang dianggap <b>Paling Menggambarkan</b> diri Anda dengan memberi tanda pada kolom "<b>M</b>" (MOST) dan memilih 1 (satu) 
									pernyataan yang dianggap <b>Paling Tidak Menggambarkan</b> diri Anda dengan memberi tanda pada kolom "<b>L</b>" (LEAST)</li>
							<li> Jadi untuk setiap pernyataan terdapat 1 (satu) buah pilihan "M" dan 1(satu) buah pilihan "L"</li>
            </ol>
						<p>Contoh soal:</p>
						<table class="table" style="background-color:#CFCFCF50">
								<thead>
									<tr>
										<th>Pernyataan</th>
										<th width="50px">Most</th>
										<th width="50px">Least</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Mudah bergaul, menyenangkan.</td>
										<td><input type="radio" disabled checked /></td>
										<td><input type="radio" disabled /></td>
									</tr>
									<tr>
										<td>Mudah percaya kepada orang lain</td>
										<td><input type="radio" disabled/></td>
										<td><input type="radio" disabled checked/></td>
									</tr>
									<tr>
										<td>Suka berpetualangan, pengambil resiko.</td>
										<td><input type="radio" disabled /></td>
										<td><input type="radio" disabled /></td>
									</tr>
									<tr>
										<td>Penuh toleransi, menghormati orang lain.</td>
										<td><input type="radio" disabled /></td>
										<td><input type="radio" disabled /></td>
									</tr>
								</tbody>
						</table>
            <?php else:?>
            <p>Petunjuk:</p>
            <p>
                Pilihlah satu jawaban yang tepat. Selamat mengerjakan dan semoga sukses!
            </p>
			<p id="infoTotalSoal"></p>
            <?php endif;?>
        </div>
    </div>
</div>

<div id="main">
	<div class="panel-soal" style="display: none;">
		<div class="row p-2" id="soal_container">
			<form class="col">
			<table class="table table_soal_disc">
				<thead>
					<tr>
						<th></th>
						<th width="50px">Most</th>
						<th width="50px">Least</th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
						<td>Pernyataan</td>
						<td><input type="radio" id="choice_m_1" name="choice_m"/></td>
						<td><input type="radio" id="choice_l_1" name="choice_l"/></td>
					</tr>
					<tr>
						<td>Pernyataan1</td>
						<td><input type="radio" id="choice_m_2" name="choice_m"/></td>
						<td><input type="radio" id="choice_l_2" name="choice_l"/></td>
					</tr>
					<tr>
						<td>Pernyataan2</td>
						<td><input type="radio" id="choice_m_3" name="choice_m"/></td>
						<td><input type="radio" id="choice_l_3" name="choice_l"/></td>
					</tr>
					<tr>
						<td>Pernyataan3</td>
						<td><input type="radio" id="choice_m_4" name="choice_m"/></td>
						<td><input type="radio" id="choice_l_4" name="choice_l"/></td>
					</tr> -->
				</tbody>
			</table>
			</form>
		</div>
	</div>
</div>
<script>
	var set_soal = function(){
		let row  = quiz_data[index]

		$(".panel-soal").show();
		
		let element_opsi = document.querySelector('table.table_soal_disc > tbody')
		let textHTML = ""
		for(let i of row.soal){
			textHTML += `<tr>
				<td>${i["question"]}</td>
				<td><input type="radio" id="${i["M"]}" name="choice_m" value="${i["M"]}" /><label for="${i["M"]}"></label></td>
				<td><input type="radio" id="${i["L"]}" name="choice_l" value="${i["L"]}" /><label for="${i["L"]}"></label></td>
			</tr>`
 		}
		element_opsi.innerHTML = textHTML
		
		validate_radio();
	}

	let validate_radio = function () {
		let choice_m = document.querySelectorAll('input[name="choice_m"]')
		let choice_l = document.querySelectorAll('input[name="choice_l"]')
		let result = {}

		choice_m.forEach(function(item, index){
			item.onclick = function(evt) {
				if(item.checked==true && choice_l[index].checked == true){
					item.checked = false;
					result['result_m'] = ''
				}
				if(item.checked == true){
					result['result_m'] = item['value']
				}
				handle_result(result)
			}
		});

		choice_l.forEach(function(item, index){
			item.onclick = function(evt) {
				if(item.checked==true && choice_m[index].checked == true){
					item.checked = false;
					result['result_l'] = ''
				}
				if(item.checked == true){
					result['result_l'] = item['value']
				}
				handle_result(result)
			}
		});
	}
	validate_radio()	

	function handle_result(result){
		let row = quiz_data[index]
		let no = row["no"]
		if(
				(result.hasOwnProperty('result_m') && result["result_m"].length>0)
				&& (result.hasOwnProperty('result_l') && result["result_l"].length>0)
		){
			show_next_button()
			if(is_tutorial == 0){
				simpan_jawaban(no,{result_m:result["result_m"],result_l:result["result_l"]})
			} 
		} else {
			hide_next_button();
		}
	}

	
</script>
