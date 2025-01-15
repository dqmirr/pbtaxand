$(function() {
    docDisc.setChart();
    $(document).ready(function() {
        console.info('window load success');
        docDisc.renderCanvas(); 
    });
})

class discPdf {
    constructor(param) {
        this.img = param.img;
        this.base = param.base;
        this.code = param.code;
        this.sesi = param.label;
		this.data = [];
		if(Array.isArray(param.data)) {
			this.data = param.data.map(item=>{
				const segment_16_list = {
					C:0,
					D:0,
					I:0,
					S:0,
				}
				if(item.disc.c_disc == null){
					item.disc.c_disc = {
						segment_16_list: segment_16_list,
                        profile: ""
					};
				}
				if(item.disc.l_disc == null){
					item.disc.l_disc = {
						segment_16_list: segment_16_list,
                        profile: ""
					};
				}
				if(item.disc.m_disc == null){
					item.disc.m_disc = {
						segment_16_list: segment_16_list,
                        profile: ""
					};
				}
				if(item.disc.disc_result == null){
					item.disc.disc_result = {
						"D": {
							"nomor": 3,
							"keterangan": "D",
							"most_total": 0,
							"least_total": 0,
							"change_total": 0
						},
						"I": {
							"nomor": 4,
							"keterangan": "I",
							"most_total": 0,
							"least_total": 0,
							"change_total": 0
						},
						"S": {
							"nomor": 5,
							"keterangan": "S",
							"most_total": 0,
							"least_total": 0,
							"change_total": 0
						},
						"C": {
							"nomor": 2,
							"keterangan": "C",
							"most_total": 0,
							"least_total": 0,
							"change_total": 0
						},
						"B": {
							"nomor": 1,
							"keterangan": "B",
							"most_total": 0,
							"least_total": 0,
							"change_total": 0
						}
					}
				}

				return {
					...item,
					formasi: item.formasi_label
				}
			}).filter(item=>!item.status.includes("Belum Dikerjakan"))
		}
    }

    setChart()
    {
        var dataUser = this.data;
        dataUser.forEach(function(val, key) {
            var dataDisc = val.disc;
			var mostDisc = docDisc.setData(dataDisc.m_disc);
			var leastDisc = docDisc.setData(dataDisc.l_disc);
			var changeDisc = docDisc.setData(dataDisc.c_disc);

			var ctxMost = document.getElementById("most_"+val.id).getContext("2d");
			var ctxLeast = document.getElementById("least_"+val.id).getContext("2d");
			var ctxChange = document.getElementById("change_"+val.id).getContext("2d");

			docDisc.configChart(ctxMost, 'Most', mostDisc);
			docDisc.configChart(ctxLeast, 'Least', leastDisc);
			docDisc.configChart(ctxChange, 'Change', changeDisc);
	});
    }

    setData(par)
    {
        var data = [
            par?.segment_16_list?.D,
            par?.segment_16_list?.I,
            par?.segment_16_list?.S,
            par?.segment_16_list?.C,
        ];
        return data;
    }

    configChart(elm, label, data)
    {
        const chartModal = new Chart(elm, {
            type: 'line',
            data: {
                labels: ['D','I','S','C'],
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: 'rgb(254,162,7, 0.5)',
                    backgroundColor: null,
                    fill: false,
                    borderWidth: 17,
                    pointBackgroundColor: 'rgb(254,162,7)',
                    pointBorderWidth: 9,
                }]
            },
            options: {
                scales: {
                    yAxes: [{ 
                        ticks: {
                            min: -8, 
                            max: 8,
                            stacked: true,
                            fontSize: 40,
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }],
                    xAxes: [{ 
                        ticks: {
                            stacked: true,
                            fontSize: 40,
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }],
                },
                legend: {
                    display: false,
                },
                elements: {
                    line: {
                        tension: 0,
                    }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'bottom',
                        font: {
                            size: 40,
                        },
                        formatter: function(value, context) {
                            return value;
                        }
                    },
                    filler: {
                        propagate: true
                    }
                }
            }
        });
    }

    renderCanvas()
    {
        var data = this.data;
		data = data
        setTimeout(function() {
            docDisc.getCanvas(data);
        }, 1000);
	console.info('render canvas success');
    }

    getCanvas(data)
    {
        var pdfCanvas = new Array();
        data.forEach(function(val, key) {
            var mostHeight = $('#most_'+val.id).innerHeight();
            var mostWidth = $('#most_'+val.id).innerWidth();
            var leastHeight = $('#least_'+val.id).innerHeight();
            var leastWidth = $('#least_'+val.id).innerWidth();
            var changeHeight = $('#change_'+val.id).innerHeight();
            var changeWidth = $('#change_'+val.id).innerWidth();
            
            var mostCanvas = $('<canvas/>').attr({
                id: "mostCanvas_"+val.id,
                width: mostWidth,
                height: mostHeight
            });
            var leastCanvas = $('<canvas/>').attr({
                id: "leastCanvas_"+val.id,
                width: leastWidth,
                height: leastHeight
            });
            var changeCanvas = $('<canvas/>').attr({
                id: "changeCanvas_"+val.id,
                width: changeWidth,
                height: changeHeight
            });

            var mostCtx = $(mostCanvas)[0].getContext('2d');
            var leastCtx = $(leastCanvas)[0].getContext('2d');
            var changeCtx = $(changeCanvas)[0].getContext('2d');

            $('canvas#most_'+val.id).each(function(index) {
                var mostHeight = $(this).innerHeight();
                var mostWidth = $(this).innerWidth();
                mostCtx.drawImage($(this)[0], 0, 0, mostWidth, mostHeight);
            });
            $('canvas#least_'+val.id).each(function(index) {
                var leastHeight = $(this).innerHeight();
                var leastWidth = $(this).innerWidth();
                leastCtx.drawImage($(this)[0], 0, 0, leastWidth, leastHeight);
            });
            $('canvas#change_'+val.id).each(function(index) {
                var changeHeight = $(this).innerHeight();
                var changeWidth = $(this).innerWidth();
                changeCtx.drawImage($(this)[0], 0, 0, changeWidth, changeHeight);
            });

            var discResult = val.disc.disc_result
            var mostSum = 0;
            var leastSum = 0;
            var changeSum = 0;
            $.each(discResult,function(key1, val1) {
                mostSum += val1.most_total;
                leastSum += val1.least_total;
                changeSum += val1.change_total;
            })

            var obj = {
                id: val.id,
                fullname: val.fullname,
                formasi: val.formasi,
                data: val.disc.disc_result,
                ori: val,
                sum: {
                    most: mostSum,
                    least: leastSum,
                    change: changeSum
                },
                profil: {
                    most: val.disc.m_disc.profile,
                    least: val.disc.l_disc.profile,
                    change: val.disc.c_disc.profile
                },
                most_chart: mostCanvas,
                least_chart: leastCanvas,
                change_chart: changeCanvas
            }
            pdfCanvas.push(obj);
        })

        var logo = new Image();
        logo.src = this.img;
        logo.onload = function() {
            docDisc.convertPDF(pdfCanvas, logo);
        }
    }

    convertPDF(canvas, logo)
    {
        var sesi_name = this.sesi;
        const doc = new jsPDF({
            orientation: 'p',
            unit: 'pt',
            format: 'a4',
            putOnlyUsedFonts: false,
            compress: true
        });

        var margin = {
            top: 40,
            bottom: 60,
            left: 40,
            width: 522
        };

        var cell = {x: 40,
            y: 40,
            width: 522,
            height: 20,
            line: 0
        };

        doc.setProperties({
            title: 'DISC Reports',
            subject: 'Grafik nilai dari DISC',
            author: 'PBTAXAND',
            creator: 'Wiratek Developer (Syarif YTH)'
        });

        canvas.forEach(function(val, key) {

            doc.addImage(logo, 'png', 
                margin.width-(90-margin.left), 
                margin.top, 
                90, 25);

            doc.setFontSize(18);
            doc.setFontType('bold');
            doc.setTextColor(0, 0, 0);
            doc.text('DISC Reports', 
                (margin.width/2)-20, 
                (margin.top+40));

            doc.setFontSize(12);
            doc.setFontType('normal');
            doc.cell(cell.x, 
                (cell.y*2.5), 
                null, null, 
                'Sesi');
            doc.cell(cell.x+55, 
                (cell.y*2.5), 
                null, null, 
                ': '+sesi_name);
            doc.cell(cell.x, 
                (cell.y*2.5)+cell.height, 
                null, null, 
                'Formasi');
            doc.cell(cell.x+55, 
                (cell.y*2.5)+cell.height,
                null, null, 
                ': '+val.formasi);
            doc.cell(cell.x, 
                (cell.y*2.5)+(cell.height*2), 
                null, null, 
                'Peserta');
            doc.cell(cell.x+55, 
                (cell.y*2.5)+(cell.height*2), 
                null, null, 
                ': '+val.fullname);


            doc.cell(cell.x*2.8, 
                (cell.y*2.5)+(cell.height*3.9), 
                null, null, 
                'Most');
            doc.cell(cell.x*7.1, 
                (cell.y*2.5)+(cell.height*3.9), 
                null, null, 
                'Least');
            doc.cell(cell.x*11.5, 
                (cell.y*2.5)+(cell.height*3.9), 
                null, null, 
                'Change');

            doc.addImage($(val.most_chart)[0], 
                'PNG', 
                cell.x-4, 195, 
                165, 330);
            doc.addImage($(val.least_chart)[0], 
                'PNG', 
                cell.x*5.35, 195, 
                165, 330);
            doc.addImage($(val.change_chart)[0], 
                'PNG', 
                cell.x*9.9, 195, 
                165, 330);

            doc.autoTable({
                theme: 'grid',
                startY: 550,
                useCss: true,
                margin: { left: 47, right: 35 },
                styles : { 
                    halign : 'center',
                    cellPadding: 5, 
                    overflow: 'ellipsize', 
                    cellWidth: 'wrap',
                    fontSize: 12
                }, 
                headStyles : {
                    fillColor : [253,207,131],
                    fontSize: 14,
                    lineWidth: 0.5,
                    textColor: 1
                }, 
                tableLineWidth: 0.6,
                head: [[
                    'Keterangan', 
                    'D', 'I', 'S', 'C', '*', 
                    'Total', 
                    'DISC Profile'
                ]],
                body: [
                    ['Most', 
                        val.data.D.most_total, 
                        val.data.I.most_total, 
                        val.data.S.most_total, 
                        val.data.D.most_total,
                        val.data.B.most_total,
                        val.sum.most,
                        val.profil.most
                    ],
                    ['Least', 
                        val.data.D.least_total, 
                        val.data.I.least_total, 
                        val.data.S.least_total, 
                        val.data.D.least_total,
                        val.data.B.least_total,
                        val.sum.least,
                        val.profil.least
                    ],
                    ['Change',
                        val.data.D.change_total, 
                        val.data.I.change_total, 
                        val.data.S.change_total, 
                        val.data.D.change_total,
                        val.data.B.change_total,
                        val.sum.change,
                        val.profil.change
                    ],
                ],
            })

            doc.cell(cell.x, 800, 
                cell.width, 0.5, ' ');
            doc.setFontSize(10);
            doc.setFontType('normal');
            doc.setTextColor(120, 130, 138);
            doc.text('DISC Reports - '+sesi_name, 
                cell.x, 811);


            
            

            if((key+1) !== canvas.length) {
                doc.addPage();
            }
        });

        const file = doc.output('bloburl', 'abc');
        docDisc.previewPDF(file);
	console.info('render PDF success');
    }

    previewPDF(file)
    {
        var options = {
            height: '1190px',
            pdfOpenParams: { 
                view: 'FitV',
                pagemode: 'thumbs'
            }
        };
    
        PDFObject.embed(file, "#pdf-preview", options);
        setTimeout(function() {
            $('#rendering').hide();
        }, 500);
    }

}
