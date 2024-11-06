<?php
    session_start();
    if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
        header("location: login.php");
        exit();
    }

    $current_dir = __DIR__;

    while ($current_dir != '/' && !file_exists($current_dir . '/index.php')) {
        $current_dir = dirname($current_dir);
    }
    require_once $current_dir . '/vendor/autoload.php';
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable($current_dir);
    $dotenv->load();
    
    require("./php/UIHandler.php");
    require("./php/APIHandler.php");
    $ui = new UIHandler();
    $api = new APIHandler();
    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    if ($session_user_info['account_confirm'] != 1) {
        header("location: account_confirm.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Holidays - Presence v<?=$_ENV["VERSION"];?></title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="./assets/css/datatables.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="./assets/css/select2.css?v=<?php echo time(); ?>">
    <script src="./assets/js/select2.js?v=<?php echo time(); ?>"></script>
    <script src="./assets/js/daily-presence.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css">
	<script src="js/sweetalert.js"></script>
    <link rel="stylesheet" href="./assets/css/holidays.css?v=<?=time();?>">
    <link rel="stylesheet" href="./assets/css/tippy.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.0/slimselect.min.js"></script>
    <style>
        @media (max-width: 768px) {
            #calendar {
                display: grid;
                grid-template-columns: repeat(7, 1fr);
                gap: 5px;
            }

            #calendar .day-name, #calendar .day {
                font-size: 12px;
                padding: 5px;
            }

            #calendar .day {
                height: 40px;  
            }

            .month-display {
                font-size: 18px;
            }
        }

        @media (max-width: 768px) {
            .text-center.mt-4 .row {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .text-center.mt-4 .col-md-3, .text-center.mt-4 .col-md-5 {
                margin-bottom: 10px;
                width: 100%;
                padding: 0 5px;
            }

            .text-center.mt-4 .col-md-3 .btn {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .panel {
                width: 100%;
                margin: 0;
            }
            
            .contacts_div {
                padding: 10px;
            }
        }
    </style>
</head>
<body id="page-top" class="politics_version">

    <div id="preloader">
        <div id="main-ld">
			<div id="loader"></div>  
		</div>
    </div> 
    
    <?php echo $ui->getNav(); ?>

    <div id="services" class="section lb">
        <div class="container">
            <div class="section-title text-center" style="padding: 0; margin: 0;">
                <h3 style="padding:0 ;">Holidays</h3>
            </div> 
            <div class="row">
                <div class="col-lg-9">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="contacts_div">
                                <div class="container mt-2">
                                    <div class="text-center mb-3">
                                        <button id="prevMonthBtn" class="btn btn-secondary">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <span id="monthDisplay" class="month-display mx-3"></span>
                                        <button id="nextMonthBtn" class="btn btn-secondary">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                    <div id="calendar" class="calendar">
                                    </div>
                                    <div class="text-center mt-4">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-md-3 pr-0">
                                                <select id="typeRequest" class="form-control">
                                                    <option value="Vacation">Vacation</option>
                                                    <option value="Unpaid Leave">Unpaid Leave</option>
                                                    <option value="Paid Leave">Paid Leave</option>
                                                    <option value="Death Vacantion">(Special) Death Vacantion</option>
                                                    <option value="Birth Vacantion">(Special) Birth Vacantion</option>
                                                    <option value="Medical Leave">Medical Leave</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5 pl-1 pr-1">
                                                <input type="text" id="reasonInput" class="form-control" placeholder="Enter reason for approval (optional)">
                                            </div>
                                            <div class="col-md-3 pl-0">
                                                <button id="getSelectedDaysBtn" class="btn btn-success w-100">Request Approval</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-3">
                    <?php if ($session_user_info['admin'] > 0 ) { ?>
                        <div class="form-group">
                            <label for="end_date">Name:</label>
                            <select id="name" name="name">
                                <option value="" selected>Select a channel</option>
                            </select>
                        </div>
                    <?php } ?>
                    <div class="legend">
                        <h5>Legend</h5>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: #007bff; border-radius: 3px; margin-right: 5px;"></span>
                            Selected Days
                        </div>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: #28a745; border-radius: 3px; margin-right: 5px;"></span>
                            Accepted
                        </div>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: #dc3545; border-radius: 3px; margin-right: 5px;"></span>
                            Rejected
                        </div>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: #ffc107; border-radius: 3px; margin-right: 5px;"></span>
                            Pending
                        </div>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: purple; border-radius: 3px; margin-right: 5px;"></span>
                            Holiday
                        </div>
                        <div>
                            <span style="display: inline-block; width: 15px; height: 15px; background-color: #6c757d; border-radius: 3px; margin-right: 5px;"></span>
                            Current Day
                        </div>
                    </div>
                    <div>
                        <p class="text-center mt-2"><b><span id="holidays_left"></span> days</b> of vacation left</p>
                    </div>
                    <?php if ($session_user_info['admin'] > 0) { ?>
                        <div style="display: flex; align-items: center; justify-content: center;">
                            <button type="button" class="btn btn-primary open_holidays_history" style="margin-left: 10px; font-size: 1rem; display: flex; align-items: center;">Show Holidays History</button>
                        </div>
                    <?php } ?>
                </div><!-- /.col-lg-3 -->
            </div><!-- /.row -->
        </div><!-- end container -->
    </div><!-- end section -->

    <?php echo $ui->getFooter(); ?>

    <div class="modal fade bd-example-modal-lg" id="holidaysHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <h1 style="text-align: center;">Holidays history</h1>
                <table id="holidays-history" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Request Date</th>
                            <th>Reason</th>
                            <th>Request At</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <a href="#" id="scroll-to-top" class="dmtop global-radius"><i class="fa fa-angle-up"></i></a>

    <script src="js/all.js"></script>
    <script src="js/jquery.easing.1.3.js"></script> 
    <script src="js/parallaxie.js"></script>
    <script src="js/headline.js"></script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/jquery.vide.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
        $(document).ready(function() {
            const calendar = $('#calendar');
            const selectedDays = new Set();
            let preSelectedDays = {};
            let currentDate = new Date();
            let holidays_left = 0;

            function getHolidays() {
                let name = $("#name").val();
                $.ajax({
                    url: "./php/getRequestHolidays.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        name: name
                    },
                    success: function (data) {
                        preSelectedDays = data.data;
                        generateCalendar(currentDate);
                        $("#holidays_left").text(data.holidays_left);
                        holidays_left = data.holidays_left;

                        tippy('[data-tippy-content]', {
                            allowHTML: true
                        });
                    }
                });
            }

            $(document).on("click", ".open_holidays_history", function() {
                $("#holidaysHistoryModal").modal("show");
                $.ajax({
                    url: "./php/getHolidaysHistory.php",
                    type: "POST",
                    data: {
                        user: $("#name").val()
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        $('#holidays-history').DataTable().destroy();
                        $('#holidays-history').DataTable({
                            pagingType: 'full_numbers',
                            processing: true,
                            data: data,
                            order: []
                        });
                    }
                });
            });

            getHolidays();

            if ($("#name").length) {
                new SlimSelect({
                    select: '#name'
                });
            }

            $(document).on("change", "#name", getHolidays);

            $.ajax({
                url: "./php/getUsers.php",
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.length) {
                        for (let i = 0; i < data.length; i++) {
                            $("#name").append("<option value='"+data[i][0]+"'>"+data[i][1]+" - "+(data[i][4] ? data[i][4] : "without job")+"</option>");
                        }
                    }
                }
            });

            $(document).on("click", "#cancelButton", function(){
                Swal.close();
            });

            function padZero(value) {
                return value < 10 ? `0${value}` : value;
            }

            $(document).on("click", ".click-pending-day", function() {
                let user_id = $(this).data("user-id");
                let user = $(this).data("user");
                let year = $(this).data("year");
                let month = padZero($(this).data("month"));
                let day = padZero($(this).data("day"));
                let type = $(this).data("type");
                let reason = $(this).data("reason");

                let date = new Date(`${year}-${month}-${day}`);
                let options = { day: 'numeric', month: 'long', year: 'numeric' };
                let formattedDate = date.toLocaleDateString('en-GB', options);

                Swal.fire({
                    title: `Manage ${user}'s holiday`,
                    html: `Type: ${type}<br>Reason: ${reason}<br>Date: <b>${formattedDate}</b>`,
                    showCancelButton: true,
                    confirmButtonText: 'Accept',
                    cancelButtonText: 'Reject',
                    footer: '<button id="cancelButton" class="swal2-cancel swal2-styled">Cancel</button>',
                    allowOutsideClick: false,
                    customClass: {
                        cancelButton: 'btn-reject'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "./php/acceptDeclineHoliday.php",
                            type: "POST",
                            data: {
                                user_id: user_id,
                                year: year,
                                month: month,
                                day: day,
                                status: "accepted"
                            },
                            dataType: "json",
                            success: function (data) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "You have just confirmed the holiday!",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        $.ajax({
                            url: "./php/acceptDeclineHoliday.php",
                            type: "POST",
                            data: {
                                user_id: user_id,
                                year: year,
                                month: month,
                                day: day,
                                status: "rejected"
                            },
                            dataType: "json",
                            success: function (data) {
                                Swal.fire({
                                    title: "Warning!",
                                    text: "You have just rejected the holiday!",
                                    icon: "warning"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        });
                    }
                });
            });

            $(window).on('load', function() {
                var tippy_interval = setInterval(function() {
                    tippy('[data-tippy-content]', {
                        allowHTML: true
                    });
                    clearInterval(tippy_interval);
                }, 1000); 
            });

            function generateCalendar(date) {
                calendar.empty();
                const daysOfWeek = ['Lu', 'Ma', 'Mi', 'Jo', 'Vi', 'Sa', 'Du'];
                daysOfWeek.forEach(day => {
                    calendar.append(`<div class="day-name">${day}</div>`);
                });

                const year = date.getFullYear();
                const month = date.getMonth() + 1;
                const firstDay = new Date(year, month - 1, 1);
                const lastDay = new Date(year, month, 0);
                const today = new Date();
                const daysInMonth = lastDay.getDate();

                $('#monthDisplay').text(date.toLocaleString('default', { month: 'long', year: 'numeric' }));

                const firstDayOfWeek = (firstDay.getDay() + 6) % 7;
                for (let i = 0; i < firstDayOfWeek; i++) {
                    calendar.append('<div class="day empty"></div>');
                }

                for (let i = 1; i <= daysInMonth; i++) {
                    const dayElement = $('<div class="day" style="position: relative;"></div>').text(i);
                    const dayDate = new Date(year, month - 1, i);
                    const dayKey = `${year}-${month}-${i}`;

                    if (dayDate.toDateString() === today.toDateString()) {
                        dayElement.addClass('current');
                    }

                    if (dayDate < today) {
                        dayElement.addClass('disabled');
                    }
                    const preSelectedDay = preSelectedDays[dayKey];
                    if (preSelectedDay && preSelectedDay.status === 'holiday') {
                        dayElement.attr('data-tippy-content', preSelectedDay.description); 
                    }
                    let permission = "<?=$session_user_info['admin']?>" > 0 ? true : false;
                    if (preSelectedDay && preSelectedDay.status === 'pending' && permission) {
                        dayElement.data("year", year);
                        dayElement.data("month", month);
                        dayElement.data("day", i);
                        dayElement.data("user-id", preSelectedDay.user_id);
                        dayElement.data("user", preSelectedDay.user);
                        dayElement.data("type", preSelectedDay.type);
                        dayElement.data("reason", preSelectedDay.reason);
                        dayElement.addClass("click-pending-day");
                        dayElement.attr('data-tippy-content', `Click to manage`); 
                    } else {
                        if ($("#name").val() != "<?=$session_user_info['id'];?>" && $("#name").val()) {
                            dayElement.addClass('disabled'); 
                        }
                    }
                    if (preSelectedDay) {
                        switch (preSelectedDay.status) {
                            case 'accepted':
                                dayElement.addClass('pre-selected-accepted');
                                dayElement.attr('data-tippy-content', `Type: ${preSelectedDay.type}<br>Reason: ${preSelectedDay.reason}`); 
                                break;
                            case 'rejected':
                                dayElement.addClass('pre-selected-rejected');
                                dayElement.attr('data-tippy-content', `Type: ${preSelectedDay.type}<br>Reason: ${preSelectedDay.reason}`); 
                                break;
                            case 'pending':
                                dayElement.addClass('pre-selected-pending');
                                break;
                            case 'holiday':
                                dayElement.addClass('pre-selected-holiday');
                                break;
                        }
                    } else {
                        dayElement.on('click', function() {
                            if (!dayElement.hasClass('pre-selected-holiday')) { 
                                toggleDaySelection(dayKey, dayElement);
                            }
                        });
                    }

                    if (selectedDays.has(dayKey)) {
                        dayElement.addClass('selected');
                    }

                    calendar.append(dayElement);
                }
            }

            function toggleDaySelection(day, element) {
                if (element.hasClass('disabled')) {
                    return;
                }
                if (selectedDays.has(day)) {
                    selectedDays.delete(day);
                    element.removeClass('selected');
                    element.css('position', ''); 
                } else {
                    selectedDays.add(day);
                    element.addClass('selected');
                    element.css('position', 'relative'); 
                }
            }

            $('#getSelectedDaysBtn').on('click', function() {
                const selectedDaysArray = Array.from(selectedDays);
                let reason_holidays = $("#reasonInput").val();
                let typeRequest = $("#typeRequest").val();
                if (selectedDaysArray.length == 0) {
                    Swal.fire("Error", "Please select at least one day!", "error");
                } else if (selectedDaysArray.length > holidays_left) {
                    Swal.fire("Error", `Sorry but you doesn't have vacation left! (selected days: ${selectedDaysArray.length}, holidays left: ${holidays_left})`, "error");
                } else {
                    $("#getSelectedDaysBtn").attr('disabled', true);
                    $.ajax({
                    url: "./php/requestHolidays.php",
                    type: "POST",
                    data: {
                        reason: reason_holidays,
                        type: typeRequest,
                        holidays: JSON.stringify(selectedDaysArray)
                    },
                    dataType: "json",
                    success: function (data) {
                            if (data.response == "success") {
                                Swal.fire({
                                    title: "Success!",
                                    text: "You have just made a leave request. Thank you!",
                                    icon: "success",
                                    allowOutsideClick: false,
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });

            $('#prevMonthBtn').on('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                generateCalendar(currentDate);

                tippy('[data-tippy-content]', {
                    allowHTML: true
                });
            });

            $('#nextMonthBtn').on('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                generateCalendar(currentDate);

                tippy('[data-tippy-content]', {
                    allowHTML: true
                });
            });
        });
    </script>
    <script src="./assets/js/datatables.js"></script>

</body>
</html>