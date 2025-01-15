$(function() {
    $(document).ready(function() {
        console.info('window load success');
        psyPDF.setPDF();
    });
})

class psycoPdf {
    constructor(param) {
        this.img = param.img;
        this.base = param.base;
        this.code = param.code;
        this.sesi = param.label;
        this.user = param.data;
    }

    setPDF()
    {
        var logo = new Image();
        logo.src = this.img;
        logo.onload = function() {
            psyPDF.convertPDF(logo);
        }
    }

    setDataPDF() // TIDAK DIGUNAKAN
    {
        // [{ content: 'Text', styles: { halign: 'center' } }]

        var data = this.user;
        var result = data.map(function(val) {

            var psycoKey = Object.keys(val.psyco);
            var result2 = psycoKey.map(function(key, numb) {
                // return ({
                //     no: numb+1,
                //     aspects: val.psyco[key].aspects,
                //     satu: val.psyco[key].TOTAL===1?'X':'',
                //     dua: val.psyco[key].TOTAL===2?'X':'',
                //     tiga: val.psyco[key].TOTAL===3?'X':'',
                //     empat: val.psyco[key].TOTAL===4?'X':'',
                //     lima: val.psyco[key].TOTAL===5?'X':'',
                // })

                return ({
                    no: numb+1,
                    aspects: val.psyco[key].aspects,
                    satu: [{
                        content: val.psyco[key].TOTAL===1?'X':'',
                        styles: { fillColor : [253,207,131] }
                    }],
                    dua: val.psyco[key].TOTAL===2?'X':'',
                    tiga: val.psyco[key].TOTAL===3?'X':'',
                    empat: val.psyco[key].TOTAL===4?'X':'',
                    lima: val.psyco[key].TOTAL===5?'X':'',
                })
            });

            return ({id:val.id,
                formasi: val.formasi,
                fullname: val.fullname,
                row: [...result2,
                {
                    no: {
                        content: 'Job Person Match',
                        colSpan: '5',
                        styles: {
                            halign: 'right',
                            cellPadding: 10,
                            fontStyle: 'bold',
                            fontSize: 14
                        },
                    },
                    empat: {
                        content: '5',
                        colSpan: '2',
                        styles: {
                            cellPadding: 10,
                            fontStyle: 'bold',
                            fontSize: 14
                        },
                    }
                },
                {
                    no: {
                        content: 'WPT Score',
                        colSpan: '5',
                        styles: {
                            halign: 'right',
                            cellPadding: 10,
                            fontStyle: 'bold',
                            fontSize: 14
                        },
                    },
                    empat: {
                        content: '5',
                        colSpan: '2',
                        styles: {
                            cellPadding: 10,
                            fontStyle: 'bold',
                            fontSize: 14
                        },
                    }
                }
            ]});

        })
        
        return result;
    }

    convertPDF(logo)
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
            title: 'Assessment Result',
            subject: 'Psycogram',
            author: 'PBTAXAND',
            creator: 'Wiratek Developer (Syarif YTH)'
        });

        // var bodyxxx = psyPDF.setDataPDF();
        // console.log(bodyxxx);
        var bodys = this.user;
        bodys.forEach(function(val, key) {
            doc.addImage(logo, 'png',
                margin.width-(90-margin.left),
                margin.top,
                90, 25);

            doc.setFontSize(18);
            doc.setFontType('bold');
            doc.setTextColor(0, 0, 0);
            doc.text('Assessment Result',
                (margin.width/2)-50,
                (margin.top+40));

            doc.setFontSize(12);
            doc.setFontType('normal');
            doc.cell(cell.x,
                (cell.y*2.5),
                null, null,
                'Nama');
            doc.cell(cell.x+80,
                (cell.y*2.5),
                null, null,
                ': '+val.fullname);
            doc.cell(cell.x,
                (cell.y*2.5)+cell.height,
                null, null,
                'Level');
            doc.cell(cell.x+80,
                (cell.y*2.5)+cell.height,
                null, null,
                ': '+val.tingkatan);

            doc.cell(cell.x + (cell.x * 8),
				(cell.y*2.5),
                null, null,
                'Tanggal Test');
            doc.cell(cell.x + (cell.x * 8) + 80,
                (cell.y*2.5),
                null, null,
                ': '+val.tgl_test);
            doc.cell(cell.x + (cell.x * 8),
                (cell.y*2.5) + cell.height,
                null, null,
                'Tanggal Lahir');
            doc.cell(cell.x+80 + (cell.x * 8),
                (cell.y*2.5)+ cell.height,
                null, null,
                ': '+val.tgl_lahir);

			const wptScore = val.psyco.splice(13,1)
            
            doc.autoTable({
                theme: 'grid',
                startY: 160,
                useCss: true,
                margin: { left: 44, right: 35 },
                styles : {
                    halign : 'center',
                    cellPadding: 4,
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
                head: [{
                    no: {
                        content: 'No',
                        styles: {cellWidth: 40},
                    },
                    aspects: {
                        content: 'Aspects',
                        styles: {halign: 'left', cellWidth: 240},
                    },
                    satu: '1',
                    dua: '2',
                    tiga: '3',
                    empat: '4',
                    lima: '5',
                }],
                body: val.psyco,
                columnStyles: {
                    aspects: { halign: 'left' },
                    satu: { fontStyle: 'bold' },
                    dua: { fontStyle: 'bold' },
                    tiga: { fontStyle: 'bold' },
                    empat: { fontStyle: 'bold' },
                    lima: { fontStyle: 'bold' },
                },
            });

            var heightCell = cell.y+(cell.height*26.8);
            if(val.description){
                doc.setFontType('bold');
                doc.cell(cell.x,
                    (cell.y+(cell.height*25)),
                    null, null,
                    'Descriptions');
    
                    
                doc.setFontSize(10);
                doc.setFontType('normal');
                
                var splitText = doc.splitTextToSize(val.description, (cell.width*0.75))
                var lineHeight = 10;
                var line = heightCell - 10;

                for(var i=0, length=splitText.length; i<length; i++) {
                    if(i == 0) {
						doc.setFontSize(9);
                        doc.cell(cell.x+10, line,
                            null, null,
                            splitText[i].trim());
                    } else {
						doc.setFontSize(9);
                        doc.cell(cell.x, line,
                            null, null,
                            splitText[i].trim());
                    }
                    line = lineHeight + line
                }
				doc.setFontSize(10);
            }
            
            cell.x = cell.x + (cell.width * 0.7);
            if(val.strength != null) {
                doc.cell(cell.x, heightCell-15,
                    null, null,
                    '\u2022');
                doc.cell(cell.x+10, heightCell-15,
                    null, null,
                    'Kekuatan');
                var kekuatan = val.strength;
                kekuatan.forEach(function(str, kstr) {

                    var splitText = doc.splitTextToSize(str, 500)
                    var lineHeight = 15;
                    var line = heightCell;

                    for(var i=0, length=splitText.length; i<length; i++) {
                        if(i == 0) {
                            doc.cell(cell.x+10, line,
                                null, null,
                                '- '+splitText[i].trim());
                        } else {
                            doc.cell(cell.x+17, line,
                                null, null,
                                splitText[i].trim());
                        }
                        line = lineHeight + line
                    }

                    heightCell = line;
                })
            }

            // var heightCell = cell.y+(cell.height*26.8);
            // if(val.strength != null) {
            //     doc.cell(cell.x, heightCell-15,
            //         null, null,
            //         '\u2022');
            //     doc.cell(cell.x+10, heightCell-15,
            //         null, null,
            //         'Kekuatan');
            //     var kekuatan = val.strength;
            //     kekuatan.forEach(function(str, kstr) {

            //         var splitText = doc.splitTextToSize(str, 500)
            //         var lineHeight = 15;
            //         var line = heightCell;

            //         for(var i=0, length=splitText.length; i<length; i++) {
            //             if(i == 0) {
            //                 doc.cell(cell.x+10, line,
            //                     null, null,
            //                     '- '+splitText[i].trim());
            //             } else {
            //                 doc.cell(cell.x+17, line,
            //                     null, null,
            //                     splitText[i].trim());
            //             }
            //             line = lineHeight + line
            //         }

            //         heightCell = line;
            //     })
            // }

            if(val.weakness != null && val.strength != null) {
                var plus = 4;
                doc.cell(cell.x, heightCell+plus,
                    null, null,
                    '\u2022');
                doc.cell(cell.x+10, heightCell+plus,
                    null, null,
                    'Kelemahan');
                var kelemahan = val.weakness;
                kelemahan.forEach(function(str, kstr) {

                    var splitText = doc.splitTextToSize(str, 500)
                    var lineHeight = 15;
                    var line = heightCell;

                    for(var i=0, length=splitText.length; i<length; i++) {
                        if(i == 0) {
                            doc.cell(cell.x+10, line+lineHeight+plus,
                                null, null,
                                '- '+splitText[i].trim());
                        } else {
                            doc.cell(cell.x+17, line+lineHeight+plus,
                                null, null,
                                splitText[i].trim());
                        }
                        line = lineHeight + line
                    }

                    heightCell = line;
                })
            }


			doc.setLineWidth(2).rect(cell.x, heightCell + (15*2), (150), (65))
			doc.setFontSize(10);
			doc.cell(cell.x + 5,
                (heightCell + (15*2) + 5 ),
                null, null,
                'English Score');
            doc.cell(cell.x+80 + 5,
                (heightCell + (15*2)+ 5 ),
                null, null,
                ': '+ val.english_score);

			doc.setFontSize(10);
            doc.cell(cell.x + 5,
                (heightCell + (15*3) + 5 ),
                null, null,
                'Accounting Score');
			doc.cell(cell.x+80 + 5,
				(heightCell + (15*3) + 5 ),
				null, null,
				': '+ `${val.accounting_score}`);

			doc.setFontSize(10);
            doc.cell(cell.x + 5,
                (heightCell + (15*4) + 5 ),
                null, null,
                'WPT Score');
			doc.cell(cell.x+80 + 5,
				(heightCell + (15*4) + 5 ),
				null, null,
				': '+ val.wpt_score);


            cell.x = cell.x - (cell.width * 0.7);
            doc.cell(cell.x, 800,
                cell.width, 0.5, ' ');
            doc.setFontSize(10);
            doc.setFontType('normal');
            doc.setTextColor(120, 130, 138);
            doc.text('Assessment Result - '+val.fullname,
                cell.x, 811);
            
            if((key+1) !== bodys.length) {
                doc.addPage();
            }
        });

        // doc.save('DOC.pdf');

        const file = doc.output('bloburl');
        psyPDF.previewPDF(file);
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

    capitalize(str)
    {
        var capital = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        return capital;
    }
}
