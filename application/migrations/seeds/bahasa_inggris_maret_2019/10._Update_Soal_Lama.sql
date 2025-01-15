/* QUESTIONS ==================================================================================== */
update multiplechoice_question set question = '______ yesterday was that company''s anniversary, every employee was invited to Glory Hotel''s ballroom to celebrate it.' where id = 231 and nomor = 1 and jenis_soal = 'english';

update multiplechoice_question set question = 'The security officer will always ______ every visitor''s identification card before entering the site.' where id = 237 and nomor = 7 and jenis_soal = 'english';

update multiplechoice_question set question = 'New regulations of transportation system which are designed to reduce port costs and increase efficiency have already had ______ results.' where id = 254 and nomor = 24 and jenis_soal = 'english';

update multiplechoice_question set question = 'The two differences ______ those two seafood restaurants are the prices of foods and the design of place.' where id = 257 and nomor = 27 and jenis_soal = 'english';

update multiplechoice_question set question = 'The ______ cost of that five star hotel is more than five hundred billion Rupiah.' where id = 265 and nomor = 35 and jenis_soal = 'english';

update multiplechoice_question set question = 'Who is Dimas Putra?' where question = 'Who is Carmen Cruz?' and id = 204 and nomor = 174 and jenis_soal = 'english';

update multiplechoice_question set question = 'Who might Steve Spencer be?' where question = 'Who might Steve Spenser be?' and id = 353 and nomor = 233 and jenis_soal = 'english';

update multiplechoice_question set question = 'What kind of goods that must not be brought by passangers?' where question = 'What kind of goods that must not be brough by passagers?' and id = 358 and nomor = 238 and jenis_soal = 'english';



/* CHOICES ======================================================================================*/
update multiplechoice_choices set label = 'recommendation' where id = 1007 and multiplechoice_question_id = 252 and choice = 'C' and label = 'reccomendation';

update multiplechoice_choices set label = 'to hire' where id = 1023 and multiplechoice_question_id = 256 and choice = 'C' and label = 'to hite';

update multiplechoice_choices set label = 'giving voice' where id = 1322 and multiplechoice_question_id = 331 and choice = 'B' and label = 'govong voice';

update multiplechoice_choices set label = 'gave' where label = 'c. gave' and choice = 'C' and id = 979 and multiplechoice_question_id = 245;

update multiplechoice_choices set label = 'prepared' where label = 'd. prepared' and choice = 'D' and id = 980 and multiplechoice_question_id = 245;

/* STORY ========================================================================================*/
update multiplechoice_story set story = '
<h4 class="text-center">
SUNVALLEY INTERNATIONAL SCHOOL<br />
-----------------------------------<br />
NOTICE</h4>
<br />
13th February 2014<br />
Inter-house Shool Debate`<br />
All the students are hereby {201}…………………….that the inter house school debate for classess VI - Vii will be held on 19th February 2014, Thursday. Students who are {202}…………………..to participate in the debate must submit their names to their respective class teachers by 16th February 2014 (Monday)<br />
Name of the Event: Inter house debate<br />
Date: 19.02.2014<br />
Vanue: School auditorium<br />
Time: 9 am onwards<br />
Topic: Computers can replace teachers by the next century<br />
For further details please contact the {203}……………………..<br />
Soumyajit Das<br />
Cultural in charge
' where 
code = 'english_17';

update multiplechoice_story set story = 'OFFICIAL NOTICE<br />
June 26, 2001<br />
Dan Debtor<br />
123 Maryland Ave Suite 123<br />
WA, 65475<br />
YOUR ACCOUNT HAS BEEN PLACED WITH THIS OFFICE FOR IMMEDIATE COLLECTION<br />
BY: Farnworth & Company, BALANCE DUE: $61,614.73<br />
My review of your account is near {204}……….at this stage my advice to your creditor to force a recovery is pending.<br />
{205}………………to respond to this notice may result in a negative report to the credit bereau. Payment in full is required to stop collection activity.<br />
You have 5 days to tender payment in full on the account or arrage for exact settlement of the balance by contacting my office at 456-0986.<br />
Should you {206}…………..this letter, you are presumed to hace no defense or alternative to just procedure. The creditor may be advised to consider immediate action. We are not presenting either directly of by implication that legal action has bveen or is being taken against you at this time.<br />
Contact today:<br />
Samuel M.<br />
President<br />
CS/10020' where 
code = 'english_18';

update multiplechoice_story set story = 'Dixie Cleverelle<br />
SavbizCor Ltd.<br />
28 Green St,, Suite 14<br />
Upstate, NY 10947<br />
October 27, 2006<br />
October 27, 2006<br />
Barnelli Ltd.<br />
48 Stanstead Road<br />
London SE27 1F<br />
For the attention of Financial Manager<br />
Dear Ms. Edward:<br />
I want to take this opportunity to thank you for the excellent job you did in arranging financing for our project. We appreciate the fact that you made yourself {207}…………….for discussion seven days a week. We were impressed by our through knowledge of financing and investment banking.<br />
We have been dealing with our new financial institution for about a week now. The advantages of association with this institution are already {208}………….. I feel as thpough we have taken a quantum leap forward in progress.<br />
I would not {209}………………..to retain your services again and to recommend your firm, to any company seeeking the best representation.<br />
Sincerely yours,<br />
Dixie Claverelle<br />
President' where 
code = 'english_19';

update multiplechoice_story set story = 'The economy expanded at a 0,5 percent rate in the January - March quarter. Economists had forcast that it would maintain or even slightly better that pace in april - June. But consumer demand, which accounts for nearly two-thirds of business activity, rose only 0.2 percent.<br />
A recent strengthening in the value of the Japanese yen, and weaker oil prices, {213} ………………progress toward a 2 percent inflation target set by Abe and the central bank.<br />
Moving to salvage his "Abenomics" strategy for  {214}…………………, Prime Minister Shinzo Abe recently proposed 28 trilion yen ($267 billion) in spending initiatives meant to get consumers and businesses to spend more monet to support the stalling recovery.' where
code = 'english_21';

update multiplechoice_story set story = '
<h4 class="text-center">Career Opportunity</h4>
<br />
Sumy Distillery Pvt. Ltd. Is seeking to recruit competent, comitted, {215} ……………..and enthusiastic Nepali candidate for the following positions.<br />
1. INSTITUTIONAL SALES MANAGER-FEW<br />
    - Master degree or equivalent from a {216} ………………….with at least 5 years experience in relevant field.<br />
    - Willingness to travel extensively as per our product distribution network<br />
    - Knowledge of computer<br />
1. INSTITUTIONAL SALES OFFICER/ASSISTANT OFFICER-FEW<br />
    - Bachelors degree or equivalent from a recognized university with at least 3 years experience in relevant field<br />
    - Willingness to travel extensively as per our product distribution network<br />
    - Knowledge of computer<br />
    - Work station: Major town of Nepal (headquarter based)<br />
Interested Nepali candidates may {217}…………....with a recent passport size photograph and CV mentioning the position applied for, within the 15 days from the advertisment in the following address:<br />
<p align="center">
Human Resource Division<br />
Sumy Distillery Pvt. Ltd.<br />
P.O. Box: 8975, EPC: 5407<br />
Balaju, Kathmandu, Nepal<br />
E-mail address: sumy@mos.com.np
</p>' where
code = 'english_22';

update multiplechoice_story set story = '
<h4 class="text-center">Administration/Accounts</h4>
<br />
Toowoomba location - $45,000+Super<br />
Challenging Account Role - Full Time<br />
Plenty of Autonomy of Ownership<br />
The business is part of Australia`s {218}……………..and industrial tool provider network.<br />
They offer a huge product range of professional tools to the industrial market and are serviced by {219}………………and experienced staff.<br />
Your part in the ongoing success of this company will see you involved day to day in a variety of accounts and administration work including:<br />
- Accounts Receivable<br />
- Accounts Payable<br />
- Invoicing and Receipting<br />
- Filing, Phoning Debtors, Mail Run and Banking<br />
- Promotions Reconciliations<br />
You will be perfect for this role if you describe yourself as someone with a can-do attitude, are  {220}…………………with strong attention to detail, have outstanding communication skills with professional presentation.<br />
To apply for this position please go to www.abertons.com.au/jobboard<br />
For more information contact us on (07) 4659 7111 or visit www.abbertons.com.au' where
code = 'english_23';

update multiplechoice_story set story = 'May 30, 2016<br />
<br />
Natalie Zen<br />
630 Simons Street<br />
Auckland, New Zealand 6692<br />
<br />
NOTICE TO TENANT OF RENT DEFAULT<br />
<br />
Dear Mrs. Zen<br />
This notice is in reference to the following {221}……………..lease:<br />
Two-floor building of Maryland Music Studio<br />
Please be advised that as of date May 25, you are in default in your payment of rent in the amount of $50,000.<br />
In this breach of lease is not corrected within 7 days of this notice, we will take further action to protect our rights, which may include {222}……………of this lease and collection proceedings. This notice is made under all {223} ……………….laws. All of our rights are reserved under this notice.<br />
Sincerely,<br /><br />
Steve Brown<br />
brownsteve@gmail.com' where
code = 'english_24'; 

update multiplechoice_story set story = 'BETTER BUSINESS BUREAU, INC.<br />
741 Delware Ave. Ste. 100, Buffalo, NY 14209-2201<br />
(716) 881-5222 Fax (716) 883-5349 info@upstatenybbb.org<br />
<br />
July 12, 2004<br />
<br />
Ms. Amy Rosier<br />
17029 Gulf Road<br />
Holley, NY 14470<br />
<br />
RE: Eagle Construction Company<br />
<br />
Dear Ms. Rosier:<br />
Enclosed is the company response to the complaint you filed with us.<br />
The Better Business Bureau tries to settle complaints between business and consumens by acting as a neutral third party, hearing both sides of the dispute. As a consequence, many complaints are resolved to both parties {224} ……………….<br />
In this case, the company has responded to the complaint by addressing the disputed issue(s) and the response is not unreasonable in our experience. Apattern of comlaints in this category would trigger a review of the company file, and might result in {225}......................…<br />
If the company`s answer is unacceptable, you may wish {226} ………………..the advice of an attorney or file a claim in Small Claims Court. The complaint will remain in the company`s file and will be reported to the public for the next three years.<br />
<br />
Sincerely,<br />
<br />
Carol Bedard<br />
cbedard@upstatebbb.org' where
code = 'english_25'; 

update multiplechoice_story set story = '
<p align="center">
Viona Patricia <br />
Palmerah, Jakarta <br />
vpatricia@email.com<br />
Tel: 08330022115
</p>
<br />
<strong>Objective</strong><br />
I am interested in continuing a challenging career in the Travel Business where my travel and computer experience will be used. <br />
<br />
<strong>Experience</strong><br />
<strong>2001 to present</strong><br />
Natural Travel Tours  <br />
• In charge of booking, ticketing, sales and customer service<br />
• Applied knowledge of the SARTRE and ONEWORLD computer systems<br />
• Organized domestic and international group tours and packaged holidays<br />
• Supervised personnel <br />
<br />
<strong>1995-1999</strong><br />
TS Corporation<br />
• Installed software for new clients and provided support at their offices<br />
• Developed online message system for members of the programming group<br />
• Supervised and guided new programmers in the team<br />
<br />
<strong>1992-1994</strong><br />
Nusantara High School <br />
• Taught English literature <br />
• Prepared lesson plans, tests, reports, projects, school activities<br />
• Editor of school magazine <br />
<br />
<br />
<strong>Education</strong><br />
BA in Education<br />
Major: English Literature <br />
Nusantara University <br />
<br />
MA in Computer Science <br />
Major: Computer Programming <br />
Nusantara University <br />
Online Travel Agent Certificate<br />
Natural College, Australia ' where
code = 'toeic_7'; 

update multiplechoice_story set story = '
<strong>Memorandum</strong>
<br />
From:  Jessica Victoria (Human Resources Director)<br />
To:  Linda Sabrina (Research & Development Manager);  Ryan Putra (Quality Control Manager)<br />
Cc:  Rebecca Edelweiss <br />
<br />
Date:  August 15, 2017<br />
Subject:  Rebecca Edelweiss<br />
<br />
As was agreed in our meeting this morning, Rebecca Edelweiss will transfer from the Quality Control department to the Research and Development department on September 1st. Her pay and benefits will remain unchanged; however, she will be eligible for a merit pay increase after a 90-day probationary period. If you have questions about this, or any other matter, please feel free to stop by my office at any time.' where
code = 'toeic_8'; 

update multiplechoice_story set story = '
<strong>PaperThree Announces Changes to Plant</strong><br />
<br />
PaperThree, Inc., a paper and cardboard manufacturer, announced plans to upgrade its main production facility in Tangerang, and noted that the improvements will reduce its carbon dioxide emissions by 70% of current levels, use a third less energy, and will also more than double total production. Dimas Aditya, spokesperson for PaperThree, said that the work would begin “sometime in the fourth quarter of this year,” and would take approximately 18 months to complete. The estimated cost is IDR 250 million. “We’re investing in technology that’s more efficient all the way around. It uses less energy, pollutes less, and allows us to produce more. It’s well worth the costs. And while we think the improvements will give us a competitive edge – our production costs will be lower – we also hope that the rest of our industry follows suit,” said Aditya. “We think that our industry as a whole can do more to save energy and reduce pollution.  We’re hoping that our competition will look to us as a model,” Aditya said.' where
code = 'toeic_9'; 

update multiplechoice_story set story = 'From:  Lusiana Putri<br />
To:  Cynthia Tatiana <br />
CC:  Briano Putra <br />
Date:  Monday, 20 March 2017  09:25:06 a.m.<br />
Subject:  TDZ 2200 Meeting<br />
Attachments:  TDZ 2200 Agenda.docx<br />
<br />
Dear Cynthia,<br />
<br />
Please find attached a copy of the meeting agenda.<br />
Thank you for agreeing to present in Briano’s place on such short notice. <br />
When he gets back on Tuesday 28th, please be sure to give him any feedback you receive on your team’s campaign. <br />
<br />
Lusiana Putri <br />
Vice President<br />
<br />
<br />
<hr />
<br />
TDZ 2200 MEETING AGENDA<br />
--------------------<br />
Purpose: To familiarize staff with the TDZ 2200 prior to its introduction to the market; To provide an overview of the planned TDZ 2200 marketing, sales, and service programs; To provide staff an opportunity to ask questions and offer suggestions regarding the TDZ 2200 release.<br />
<br />
Date:  March 27, 2017<br />
Place:  Conference Room 4<br />
Time:  9:30 a.m. – 4:00 p.m.<br />
Attendees:  Sales Managers; Marketing Team; Sales Representatives; Customer Service Agents<br />
<br />
<br />
<br />
<table border="1" style="border-collapse: collapse;" width="100%" cellpadding="3">
	<thead>
		<tr>
			<th>Topic</th>
			<th>Presenter</th>
			<th>Format</th>
			<th>Time</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				The TDZ 2200: <br />
				What it is, who it''s for
			</td>
			<td>
				Agung Prasetyo <br />
				R&D Team 
			</td>
			<td>
				Presentation
			</td>
			<td>
				9.30 a.m - 10.30 a.m
			</td>
		</tr>
		<tr>
			<td>Coffee Break</td>
			<td>----------</td>
			<td>Break</td>
			<td>10.30 a.m - 10.45 a.m</td>
		</tr>
		<tr>
			<td>
				The Marketing Campaign: <br />
				Main features & selling points 
			</td>
			<td>
				Chyntia Tatiana <br />
				Marketing Team 
			</td>
			<td>Presentation</td>
			<td>10.45 a.m - 11.45 a.m</td>
		</tr>
		<tr>
			<td>Coffee Break</td>
			<td>----------</td>
			<td>Break</td>
			<td>11.45 a.m - Noon</td>
		</tr>
		<tr>
			<td>
				The Sales Strategy: <br />
				Customers & Sales Incentives 
			</td>
			<td>
				Ani Lestari <br />
				Sales Team 
			</td>
			<td>Presentation</td>
			<td>Noon - 1.00 p.m</td>
		</tr>
		<tr>
			<td>Lunch Break</td>
			<td>----------</td>
			<td>Break</td>
			<td>1.00 p.m - 1.30 p.m</td>
		</tr>
		<tr>
			<td>
				Service Considerations: <br />
				After-sales Issues & Warranties 
			</td>
			<td>
				Bayu Saputra <br />
				Customer Service Team 
			</td>
			<td>Presentation</td>
			<td>1.30 p.m - 2.30 p.m </td>
		</tr>
		<tr>
			<td>Coffee Break</td>
			<td>----------</td>
			<td>Break</td>
			<td>2.30 p.m - 2.45 p.m</td>
		</tr>
		<tr>
			<td>
				Discussion: <br />
				Your comments & questions 
			</td>
			<td>Open</td>
			<td>Discussion</td>
			<td>2.45 p.m - 4.00 p.m</td>
		</tr>
	</tbody>
</table>' where
code = 'toeic_13'; 

update multiplechoice_story set story = '
<h4 class="text-center">
INNES AEROSPACE<br />
Sudirman, Jakarta <br />
June 1, 2017<br />
</h4>
Mr. Lukman Prasetya <br />
Triangle Industries<br />
Palmerah, Jakarta <br />
<br />
RE: Order # TI1285720<br />
<br />
Dear Mr. Prasetya, <br />
<br />
We have reviewed our records and found that the correct price for IA50 Advanced Thrusters you ordered is indeed IDR 5,500,000 not IDR 8,000,000 as was indicated on your invoice.<br />
<br />
Thank you for calling attention to our error. We regret any inconvenience this may have caused you. <br />
A corrected invoice accompanies this letter.<br />
<br />
Please note that we have applied a 10% discount to the original shipping and handling fees as a token of our appreciation for your patience and understanding in this matter.<br />
We value your business and look forward to serving you again in the future. If you have any questions, please do not hesitate to call.<br />
<br />
<br />
<br />
Sincerely,<br />
Annisa Putriana <br />
Billing Department<br />
Encl: invoice<br />
<hr />
<br />
<h4 class="text-center">
	INNES AEROSPACE<br />
	Sudirman, Jakarta <br />
	June 1, 2017<br />
	I N V O I C E<br />
</h4>
<p align="center" class="text-center">
	Mr. Lukman Prasetya <br />
	Triangle Industries<br />
	Palmerah, Jakarta <br />
	Order #: TI1285720<br />
	Invoice #: IA548732<br />
</p>
<br />
<table width="100%" cellspacing="0" cellpadding="3">
	<tbody>
		<tr>
			<td style="border-bottom: 1px solid #000;">Description</td>
			<td style="border-bottom: 1px solid #000;">Quantity</td>
			<td style="border-bottom: 1px solid #000;">Price (Each)</td>
			<td style="border-bottom: 1px solid #000;">Total</td>
			<td style="border-bottom: 1px solid #000;">Status</td>
		</tr>
		<tr>
			<td>IA50 Advanced Thruster	</td>
			<td>3	</td>
			<td>IDR 5,500,000	</td>
			<td>IDR 16,500,000	</td>
			<td>Shipped 5/20 </td>
		</tr>
		<tr>
			<td>Custom Chassis 	</td>
			<td>3	</td>
			<td>IDR 1,200,000	</td>
			<td>IDR 3,600,000	</td>
			<td>Shipped 5/20 </td>
		</tr>
		<tr>
			<td>IA14 Low-Noise Precision	</td>
			<td>1	</td>
			<td>IDR 800,000	</td>
			<td>IDR 800,000	</td>
			<td>Shipped 5/20 </td>
		</tr>
		<tr>
			<td>Instrumentation Amplifier</td>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Subtotal:</td>
			<td>IDR 20,900,000</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Shipping:</td>
			<td>IDR 1,500,000</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Subtotal:</td>
			<td>IDR 22,400,000</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Discount:</td>
			<td>IDR 150,000</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Total:</td>
			<td>IDR 22,250,000</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
			<td>Amount Due:</td>
			<td>IDR 22,250,000</td>
		</tr>
	</tbody>
</table>
<br />
Notes: <br />
This invoice supersedes invoice #: IA548731 and reflects a shipping discount.<br />
<br />' where
code = 'toeic_15'; 
