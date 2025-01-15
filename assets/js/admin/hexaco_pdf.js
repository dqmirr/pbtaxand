function parseQueryString() {

    var str = window.location.search;
    var objURL = {};

    str.replace(
        new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
        function( $0, $1, $2, $3 ){
            objURL[ $1 ] = $3;
        }
    );
    return objURL;
};


$(function() {
    hexPDF.setChart();
    // $(window).on('load', function () {
        // hexPDF.renderCanvas(); 
    // });

    $(document).ready(function() {
        console.info('window load success');
        hexPDF.renderCanvas(); 
    });
})

class hexacoPdf {
    constructor(param) {
        this.img = param.img;
        this.base = param.base;
        this.code = param.code;
        this.data = this.getAllData();
    }

    getChildBar()
    {
        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_psycogram/child_bar_pdf`,
            type: 'post',
            dataType: 'json',
            data: {data:this.data},
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert('getChildBar', res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert('getChildBar',errorMessage);
            }
        });
        return data;
    }

    configChildBar(elm, data)
    {
        const barChart = new Chart(elm, {
            type: 'horizontalBar',
            data: data,
            options: {
                legend: {
                    display: false
                },
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            return '';
                        },
                    }
                },
                scales: {
                    yAxes: [{
                        display: false
                    }],
                    xAxes: [{
                        ticks: {
                            suggestedMax: 100,
                            beginAtZero: true,
                            stepSize: 25,
                            callback: function(value, index, values) {
                                return value+'%';
                            } 
                        },
                        stacked: true,
                        display: false,
                    }]
                }
            }
        });
    }

    getDataRadar(user)
    {
        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_psycogram/data_radar`,
            type: 'post',
            dataType: 'json',
            data: {data:user},
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert(res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        return data;
    }

    getAllData(code)
    {
        if(!code) {
            var codeSesi = this.code;
        } else {
            var codeSesi = code;
        }

		var dataget = parseQueryString();
		var usersId = decodeURI(dataget['users_id']);

		var endpoint = '/ajax_psycogram/data_pdf_all'

		if(usersId !== 'undefined'){
			endpoint = endpoint + `?users_id=${usersId}`
		}

        var data = new Array();
        $.ajax({
            url: `${this.base}` + endpoint,
            type: 'post',
            data: {code_sesi:codeSesi},
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert('getPdfAll',res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert('getDataPdfAll', errorMessage);
            }
        });
        return data;
    }

    setChart()
    {
	console.info('config chart running...');
        var data = this.data;
        var radar = this.getDataRadar(data);
        radar.forEach(function(val, key) {
            var elm = 'radar_'+val.id;
            hexPDF.configRadar(elm, val.grafik);
        });

        var child = this.getChildBar(data);
        child.forEach(function(val, key) {
            $.each(val, function(key1, val1) {
                var elmBar = 'bar_'+val1.code+'_'+val1.id;
                hexPDF.configChildBar(elmBar, val1.grafik);
            })
        });
    }

    renderCanvas()
    {
        var data = this.data;
        setTimeout(function() {
            hexPDF.getCanvas(data);
        }, 1000);
    }

    getCanvas(data)
    {
        var pdfCanvas = new Array();
        data.forEach(function(val, key) {
            var radarHeight = $('#radar_'+val.id).innerHeight();
            var radarWidth = $('#radar_'+val.id).innerWidth();

            var barHeHeight = $('#bar_he_'+val.id).innerHeight();
            var barHeWidth = $('#bar_he_'+val.id).innerWidth();

            var barEmHeight = $('#bar_em_'+val.id).innerHeight();
            var barEmWidth = $('#bar_em_'+val.id).innerWidth();

            var barExHeight = $('#bar_ex_'+val.id).innerHeight();
            var barExWidth = $('#bar_ex_'+val.id).innerWidth();

            var barAgHeight = $('#bar_ag_'+val.id).innerHeight();
            var barAgWidth = $('#bar_ag_'+val.id).innerWidth();

            var barCoHeight = $('#bar_co_'+val.id).innerHeight();
            var barCoWidth = $('#bar_co_'+val.id).innerWidth();

            var barOpHeight = $('#bar_op_'+val.id).innerHeight();
            var barOpWidth = $('#bar_op_'+val.id).innerWidth();
    
            var radarCanvas = $('<canvas/>').attr({
                id: "radarCanvas_"+val.id,
                width: radarWidth,
                height: radarHeight
            });

            var barHeCanvas = $('<canvas/>').attr({
                id: "barHeCanvas_"+val.id,
                width: barHeWidth,
                height: barHeHeight
            });

            var barEmCanvas = $('<canvas/>').attr({
                id: "barEmCanvas_"+val.id,
                width: barEmWidth,
                height: barEmHeight
            });

            var barExCanvas = $('<canvas/>').attr({
                id: "barExCanvas_"+val.id,
                width: barExWidth,
                height: barExHeight
            });

            var barAgCanvas = $('<canvas/>').attr({
                id: "barHeCanvas_"+val.id,
                width: barAgWidth,
                height: barAgHeight
            });

            var barCoCanvas = $('<canvas/>').attr({
                id: "barCoCanvas_"+val.id,
                width: barCoWidth,
                height: barCoHeight
            });

            var barOpCanvas = $('<canvas/>').attr({
                id: "barOpCanvas_"+val.id,
                width: barOpWidth,
                height: barOpHeight
            });

            var radarCtx = $(radarCanvas)[0].getContext('2d');
            var barHeCtx = $(barHeCanvas)[0].getContext('2d');
            var barEmCtx = $(barEmCanvas)[0].getContext('2d');
            var barExCtx = $(barExCanvas)[0].getContext('2d');
            var barAgCtx = $(barAgCanvas)[0].getContext('2d');
            var barCoCtx = $(barCoCanvas)[0].getContext('2d');
            var barOpCtx = $(barOpCanvas)[0].getContext('2d');

            $('canvas#radar_'+val.id).each(function(index) {
                var radarHeight = $(this).innerHeight();
                var radarWidth = $(this).innerWidth();
                radarCtx.drawImage($(this)[0], 0, 0, radarWidth, radarHeight);
            });

            $('canvas#bar_he_'+val.id).each(function(index) {
                var barHeHeight = $(this).innerHeight();
                var barHeWidth = $(this).innerWidth();
                barHeCtx.drawImage($(this)[0], 0, 0, barHeWidth, barHeHeight);
            });

            $('canvas#bar_em_'+val.id).each(function(index) {
                var barEmHeight = $(this).innerHeight();
                var barEmWidth = $(this).innerWidth();
                barEmCtx.drawImage($(this)[0], 0, 0, barEmWidth, barEmHeight);
            });

            $('canvas#bar_ex_'+val.id).each(function(index) {
                var barExHeight = $(this).innerHeight();
                var barExWidth = $(this).innerWidth();
                barExCtx.drawImage($(this)[0], 0, 0, barExWidth, barExHeight);
            });

            $('canvas#bar_ag_'+val.id).each(function(index) {
                var barAgHeight = $(this).innerHeight();
                var barAgWidth = $(this).innerWidth();
                barAgCtx.drawImage($(this)[0], 0, 0, barAgWidth, barAgHeight);
            });

            $('canvas#bar_co_'+val.id).each(function(index) {
                var barCoHeight = $(this).innerHeight();
                var barCoWidth = $(this).innerWidth();
                barCoCtx.drawImage($(this)[0], 0, 0, barCoWidth, barCoHeight);
            });

            $('canvas#bar_op_'+val.id).each(function(index) {
                var barOpHeight = $(this).innerHeight();
                var barOpWidth = $(this).innerWidth();
                barOpCtx.drawImage($(this)[0], 0, 0, barOpWidth, barOpHeight);
            });

            var obj = {
                id: val.id,
                fullname: val.fullname,
                sesi: val.sesi,
                formasi: val.formasi,
                data: val.data,
                radar: radarCanvas,
                barhe: barHeCanvas,
                barem: barEmCanvas,
                barex: barExCanvas,
                barag: barAgCanvas,
                barco: barCoCanvas,
                barop: barOpCanvas,
            }
            pdfCanvas.push(obj);
        });

        var logo = new Image();
        logo.src = this.img;
        logo.onload = function() {
            hexPDF.convertPDF(pdfCanvas, logo);
        }
    }

    configRadar(elm, data)
    {
        const radarChart = new Chart(elm, {
            type: 'radar',
            data: { 
                labels: [
                    'Honesty-Humility',
                    'Emotionality',
                    'eXtroversion',
                    'Agreeableness',
                    'Conscien-tiousness',
                    'Openness'
                ],
                datasets: data
            },
            options: {
                responsive: true,
                elements: {
                    line: { borderWidth: 3 }
                },
                legend: {
                    labels: {
                        padding: 40,
                        fontSize: 24,
                    }
                },
                scale: {
                    display: true,
                    angleLines: {
                        display: true,
                        borderWidth: 3
                    },
                    pointLabels: {
                        fontSize: 24,
                        fontColor: 'black',
                        fontStyle: 'bold',
                        callback: function(value, index, values) {
                            return value;
                        }
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        stepSize: 20, 
                        maxTicksLimit: 10, 
                        fontSize: 24,
                        callback: function(value, index, values) {
                            return value+'%';
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            return '';
                        }
                    },
                }
                
            },
        });
        
    }

    convertPDF(canvas, logo)
    {
        // const doc = new jsPDF('p', 'pt', 'a4');
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
            title: 'Hexaco Reports',
            subject: 'Grafik nilai dari Hexaco',
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
            doc.text('Hexaco Reports', 
                (margin.width/2)-26, 
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
                ': '+val.sesi);
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

            doc.addImage($(val.radar)[0], 
                'PNG', 
                -25, 155, 
                650, 330);

            var p = { top: 140 }
            var bar = { wd: 127, hg: 55 }

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x, 370+p.top, 
                null, null, 
                'Honesty-Humility');
            doc.cell(cell.x*6.4, 370+p.top,
                null, null,
                val.data.He.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.He.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x, 390+line+p.top,
                    null, null, 
                    val1.label);
                doc.cell(cell.x*6.5, 390+line+p.top,
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barhe)[0], 
                'PNG', 
                cell.x*3.3, 531, 
                bar.wd, bar.hg);

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x*7.4, 370+p.top,
                null, null, 
                'Agreeableness');
            doc.cell(cell.x*13.3, 370+p.top,
                null, null,
                val.data.Ag.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.Ag.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x*7.4, 390+line+p.top, 
                    null, null, 
                    val1.label);
                doc.cell(cell.x*13.4, 390+line+p.top,
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barag)[0], 
                'PNG', 
                cell.x*10.2, 531, 
                bar.wd, bar.hg);

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x, 455+p.top,
                null, null, 
                'Emotionality');
            doc.cell(cell.x*6.4, 455+p.top,
                null, null,
                val.data.Em.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.Em.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x, 475+line+p.top,
                    null, null, 
                    val1.label);
                doc.cell(cell.x*6.5, 475+line+p.top,
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barem)[0], 
                'PNG', 
                cell.x*3.3, 616, 
                bar.wd, bar.hg);

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x*7.4, 455+p.top,
                null, null, 
                'Conscientiousnesss');
            doc.cell(cell.x*13.3, 455+p.top,
                null, null,
                val.data.Co.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.Co.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x*7.4, 475+line+p.top, 
                    null, null, 
                    val1.label);
                doc.cell(cell.x*13.4, 475+line+p.top, 
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barco)[0], 
                'PNG', 
                cell.x*10.2, 616, 
                bar.wd, bar.hg);

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x, 540+p.top, 
                null, null, 
                'Extraversion');
            doc.cell(cell.x*6.4, 540+p.top,
                null, null,
                val.data.Ex.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.Ex.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x, 560+line+p.top, 
                    null, null, 
                    val1.label);
                doc.cell(cell.x*6.5, 560+line+p.top, 
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barex)[0], 
                'PNG', 
                cell.x*3.3, 701, 
                bar.wd, bar.hg);

            doc.setFontSize(12);
            doc.setFontType('bold');
            doc.cell(cell.x*7.4, 540+p.top, 
                null, null, 
                'Openness to Experience');
            doc.cell(cell.x*13.3, 540+p.top,
                null, null,
                val.data.Op.nilai.toString()+'%');
            doc.setFontSize(10);
            doc.setFontType('normal');
            val.data.Op.child.forEach(function(val1, key1) {
                var line = (key1*14);
                doc.cell(cell.x*7.4, 560+line+p.top, 
                    null, null, 
                    val1.label);
                doc.cell(cell.x*13.4, 560+line+p.top, 
                    null, null, 
                    val1.nilai.toString()+'%');
            })

            doc.addImage($(val.barop)[0], 
                'PNG', 
                cell.x*10.2, 701, 
                bar.wd, bar.hg);

            doc.cell(cell.x, 800, 
                cell.width, 0.5, ' ');
            doc.setFontSize(10);
            doc.setFontType('normal');
            doc.setTextColor(120, 130, 138);
            doc.text('Hexaco Reports - '+val.sesi, 
                cell.x, 811);
            if((key+1) !== canvas.length) {
                doc.addPage();
            }
        });

        const file = doc.output('bloburl');
        hexPDF.previewPDF(file);
	console.info('Render PDF Success');
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
