<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(APPPATH.'libraries/Prince.php');
use Prince\Prince;

class Prince_psycogram extends CI_Controller
{
    private $admin_url;
    private $base;
	private $prince;
    public function __construct()
    {
        parent::__construct();

        $target = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['SERVER_ADDR'];
        if(!in_array($target, $this->config->item('admin_allow_host'))) {
            die('Method Not Allowed');
        } else {
            $this->admin_url = $this->uri->segment(1);
            $this->base = base_url($this->admin_url);
			$this->prince = new Prince('/usr/local/bin/prince');
            if($this->session->userdata('is_admin') <= 0) {
                $res['message'] = 'Session Berakhir';
                $res['redirect'] = $this->base.'/login';
                alert_js($res);
                die();
            } else {
                $this->session->set_userdata('admin_controller', $this->admin_url);
            }
        }
    }

    public function index()
    {
		// $this->load->view('Admin/psycogram_pr');
		// die();

        $date = date('Ymd');
		$file = "assets/Prince/Temp_".$date.".pdf";
		$name = "Pdf Prince";
		unlink($file);
		
		$this->prince->setInputType("HTML");
		$this->prince->setHTML(true);
		$this->prince->setLog("assets/Prince/log_prince.txt");
		$this->prince->setPDFTitle($name);
		$html = $this->html_pdf();
		// $html = $this->load->view('Admin/psycogram_pr');

		$convert = $this->prince->convert_string_to_file($html, $file);
		if(!$convert) {
			print_r('Terjadi kesalahan Convert PDF.');
		} else {
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="'.$file.'"');
			header('Content-Transfer-Encoding: binary');
			header('Accept-Ranges:bytes');
			readfile($file);
		}
    }

    private function css_pdf()
	{
		$page = '@page {
			margin-left: 2cm !important;
			margin-top: 1.5cm !important;
			margin-right: 1.5cm !important;
			margin-bottom: 1.5cm !important;
			font-family: Arial, DejaVu Sans, DejaVu LGC Sans, Liberation Sans;
			size: A4 portrait;
		}
		@page bab {
			margin-left: 2cm !important;
			margin-top: 1.5cm !important;
			margin-right: 1.5cm !important;
			margin-bottom: 2cm !important;
			font-family: Arial, DejaVu Sans, DejaVu LGC Sans, Liberation Sans;
			size: A4 portrait;
			@bottom {
				content: flow(footer);
				position: fixed;
			}
		} 
		page {
			font-family: Arial, DejaVu Sans, DejaVu LGC Sans, Liberation Sans;
		}

		#footer {
			display: block;
			flow: static(footer, start);
			color: grey !important;
			font-family: Arial, DejaVu Sans, DejaVu LGC Sans, Liberation Sans
		}
		#footer .identity-border {
			border: 1px solid #AAA !important;
			margin-top: -35px !important;
		}
		#footer .name_footer,
		#footer .page_footer {
			margin-top: -28px !important;
		}
		.name_footer {
			float: left !important;	
		}
		.page_footer {
			float: right !important;
			content: counter(page)" / "counter(pages);
		}
		

		.table {
			width: 100% !important;
			table-layout: fixed;
			
		}
		.table tr td {
		}

		.logo {
			width: 100px !important;
		}
		
		.tx-line { text-decoration: underline !important; }
		.tx-just { text-align: justify !important; }
		.tx-bottom { vertical-align: text-bottom !important; }
		.tx-left { text-align: left !important; }
		.tx-right { text-align: right !important; }
		.tx-top { vertical-align: top !important; }
		.tx-center { text-align: center !important; }
		.br-avoid { page-break-inside: avoid !important; }
		.br-auto { page-break-inside: auto !important; }
		.fz-9 { font-size: 9pt !important; }
		.fz-10 { font-size: 10pt !important; }
		.fz-11 { font-size: 11pt !important; }
		.fz-12 { font-size: 12pt !important; }
		.fz-13 { font-size: 13pt !important; }
		.fz-14 { font-size: 14pt !important; }
		.fz-15 { font-size: 15pt !important; }
		.fz-16 { font-size: 16pt !important; }';
		return $page;
	}

	private function html_pdf()
	{
		$html = '<html>
			<style>
			'.$this->css_pdf().'
			</style>

			<page>
				<table class="table">
					<tr>
						<td></td>
						<td style="width: 400px"></td>
						<td align="center">
							<img class="logo" src="'.base_url().'/assets/images/logo.png">
						</td>
					</tr>
					<tr>
						<td></td>
						<td align="center">
							<b class="fz-14"><u>HEXACO REPORT</u></b><br>
							INI NAMA SESI
						</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							Nama: ini fullname
						</td>
						<td></td>
					</tr>

					<tr><td colspan="3"></td></tr>
					<tr>
						<td colspan="3">
							<canvas id="radar"></canvas>
						</td>
					</tr>

				</table>
			</page>

			'.$this->footer_pdf().'
		</html>';
		return $html;
	}

	private function footer_pdf()
	{
		$footer = '<div id="footer" class="fz-9">
			<hr class="identity-border">
			<div class="name_footer">Prince</div>
			<div class="page_footer"></div>
		</div>';
		return $footer;
	}

}