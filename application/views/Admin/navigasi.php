


<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light justify-content-between header shadow">
    <button class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="<?=$base?>">
        <?php
        if($logo != '') {
            echo '<img src="'.$logo.'" alt="'.$app_name.'">';
        } else {
            $app_name;
        }
        ?>
    </a>

    <div class="collapse navbar-collapse"
        id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav">
                <a class="nav-link <?=isset($nav['dashboard']) ? $nav['dashboard'] : '' ?>"
                    href="<?=$base;?>">
                    Dashboard
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=isset($nav['quiz']) ? $nav['quiz'] : '' ?>"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">Quiz</a>
                <div class="dropdown-menu"
                    aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?=isset($nav['child']['quiz']) ? $nav['child']['quiz'] : '' ?>" href="<?=$base?>/quiz">Quiz</a>
                    <a class="dropdown-item <?=isset($nav['child']['group']) ? $nav['child']['group'] : '' ?>" href="<?=$base?>/quiz_group">Group</a>
                    <a class="dropdown-item <?=isset($nav['child']['group_item']) ? $nav['child']['group_item'] : '' ?>" href="<?=$base?>/quiz_group_items">Group Items</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=isset($nav['soal']) ? $nav['soal'] : ''?>" href="3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Soal</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?=isset($nav['soal']['gti']) ? $nav['soal']['gti'] : '' ?>" href="<?=$base?>/soal/gti">GTI</a>
                    <a class="dropdown-item <?=isset($nav['soal']['multiplechoice']) ? $nav['soal']['multiplechoice'] : '' ?>" href="<?=$base?>/soal/multiplechoice">Multiplechoice</a>
					<a class="dropdown-item <?=isset($nav['soal']['preview']) ? $nav['soal']['preview'] : '' ?>" href="<?=$base?>/preview_soal">Preview</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item <?=isset($nav['soal']['generate']) ? $nav['soal']['generate'] : '' ?>" href="<?=$base?>/generate_paket_soal">Generate Paket Soal</a>
					<a class="dropdown-item <?=isset($nav['soal']['generate_exam']) ? $nav['soal']['generate_exam'] : '' ?>" href="<?=$base?>/soal/generate_exam">Generate Exam</a>
                </div>
            </li>

            <li class="nav">
                <a class="nav-link <?=isset($nav['sesi']) ? $nav['sesi'] : '' ?>" href="<?=$base?>/sesi">Sesi</a>
            </li>
            <li class="nav">
                <a class="nav-link <?=isset($nav['formasi']) ? $nav['formasi'] : '' ?>" href="<?=$base?>/formasi">Formasi</a>
            </li>
            <li class="nav">
                <a class="nav-link <?=isset($nav['users']) ? $nav['users'] : '' ?>" href="<?=$base?>/users">Users</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=isset($nav['report']) ? $nav['report'] : '' ?>"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">Report</a>
                <div class="dropdown-menu"
                    aria-labelledby="navbarDropdown">

                    <a class="dropdown-item <?=isset($nav['child']['generate']) ? $nav['child']['generate'] : '' ?>" href="<?=$base?>/report_generate">Generate</a>
                    <a class="dropdown-item <?=isset($nav['child']['psycogram']) ? $nav['child']['psycogram'] : '' ?>" href="<?=$base?>/psycogram">Psychogram</a>
                </div>
            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?=isset($nav['system']) ? $nav['system'] : '' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                System
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="nav-link <?=isset($nav['system']['custom_reports']) ? $nav['system']['custom_reports'] : '' ?>" href="<?=$base?>/custom_reports">Custom Reports</a>
                    <a class="nav-link <?=isset($nav['system']['settings']) ? $nav['system']['settings'] : '' ?>" href="<?=$base?>/settings">Settings</a>
                    <a class="nav-link <?=isset($nav['system']['email_job']) ? $nav['system']['email_job'] : '' ?>" href="<?=$base?>/email_job">Email Job</a>
                    <a class="nav-link <?=isset($nav['system']['upload_users']) ? $nav['system']['upload_users'] : '' ?>" href="<?=$base?>/upload_users">Upload Users&hellip;</a>
                    <a class="nav-link <?=isset($nav['system']['jadwal_quiz']) ? $nav['system']['jadwal_quiz'] : '' ?>" href="<?=$base?>/users_quiz_terjadwal">Users Quiz Terjadwal&hellip;</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="col-sm-12 col-lg-2 text-right">
        <a class="btn btn-outline-primary mr-3" href="<?=$base?>/change_password">
            <span class="oi oi-person"></span>
        </a>
        <button class="btn btn-outline-danger" type="button" id="logout_button">Logout</button>
    </div>
</nav>
