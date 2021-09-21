<?php

/**
 * @param string $date
 * @return int
 *
 */
function days_to_birth(string $date): int
{
    if (empty($date)) {
        return -1;
    }

    if ($date == '0000-00-00') {
        return -1;
    }

    $ts = strtotime($date . ' 00:00:00');
    $bY = date('Y', $ts);
    $bm = date('m', $ts);
    $bd = date('d', $ts);

    $nowY = date('Y');
    $nowm = date('m');
    $nowd = date('d');


    if ($bm == $nowm && $bd >= $nowd) {
        return $bd - $nowd;
    }

    if (($bm == $nowm && $bd < $nowd) || ($bm < $nowm)) {
        $nextBirth = ($nowY + 1) . '-' . $bm . '-' . $bd;
        $nextBirthTs = strtotime($nextBirth);
        $diff = $nextBirthTs - time();
        return floor($diff / (60 * 60 * 24));
    }

    if ($bm > $nowm) {
        $nextBirth = $nowY . '-' . $bm . '-' . $bd . '00:00:00';
        $diff = strtotime($nextBirth) - time();
        return floor($diff / (60 * 60 * 24));
    }

    return -1;
}


/**
 * Render the stylesheet for the birthdays table.
 */
function attachTableStylesheet()
{
    echo '
		<style>
			.limiter {
				width: 100%;
				margin: 0 auto;
			}

			.container-table100 {
				width: auto;
				background: transparent;
        		
        		display: -webkit-box;
        		display: -webkit-flex;
        		display: -moz-box;
        		display: -ms-flexbox;
        		display: flex;
        		align-items: center;
        		justify-content: center;
        		flex-wrap: wrap;
        		padding: 33px 30px;
        	}
        
	        .wrap-table100 {
	        	width: 1170px;
	        }
        
	        .birthday-table {
	        	border-spacing: 1;
	        	border-collapse: collapse;
	        	background: white;
	        	border-radius: 10px;
	        	overflow: hidden;
	        	width: 100%;
	        	margin: 0 auto;
	        	position: relative;
	        	border: 1px solid rgba(0, 0, 0, 0.1);
	        	-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
	        	-moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
	        	box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
	        	-webkit-background-clip: padding-box;
	        	-moz-background-clip: padding-box;
	        	background-clip: padding-box;
	        }
	        .birthday-table * {
	        	position: relative;
	        }
	        .birthday-table td, .birthday-table th {
	        	padding-left: 2.5em;
	        }
	        .birthday-table thead tr {
	        	height: 60px;
	        	background: #1d2327;
	        }
	        .birthday-table tbody tr {
	        	height: 50px;
	        }
	        .birthday-table tbody tr:last-child {
	        	border: 0;
	        }
	        .birthday-table td, .birthday-table th {
	        	text-align: left;
	        }
	        .birthday-table td.l, .birthday-table th.l {
	        	text-align: right;
	        }
	        .birthday-table td.c, .birthday-table th.c {
	        	text-align: center;
	        }
	        .birthday-table td.r, .birthday-table th.r {
	        	text-align: center;
	        }

        
	        .table100-head th{
	          	font-family: inherit;
	          	font-size: 18px;
	          	color: #fff;
	          	line-height: 1.2;
	          	font-weight: 600;
	        }
        
	        .birthday-table-body tr:nth-child(even) {
	        	background-color: #f5f5f5;
	        }
        
	        .birthday-table-body tr {
	          	font-family: inherit;
	          	font-size: 15px;
	          	color: #808080;
	          	line-height: 1.2;
	          	font-weight: unset;
	        }
        
	        .birthday-table-body tr:hover {
	          	color: #555555;
	          	background-color: rgba(251, 196, 31, 0.5);
	          	cursor: pointer;
	        }
        
	        .column1 {
	        	width: 110px;
	        	padding-left: 40px;
	        }
	        
	        .column2 {
	        	width: 110px;
	        }
	        
	        .column3 {
	        	width: 110px;
	        }
	        
	        .column4 {
	        	width: 150px;
	        	text-align: left;
	        }
        
        
	        @media screen and (max-width: 992px) {
				.birthday-table {
					display: block;
				}
				.birthday-table > *, .birthday-table tr, .birthday-table td, .birthday-table th {
					display: block;
					width: auto;
				}
				.birthday-table thead {
					display: none;
				}
				.birthday-table .birthday-table-body tr {
					height: auto;
					padding: 24px 0;
				}
				.birthday-table .birthday-table-body tr td {
					padding-left: 45% !important;
					margin-bottom: 24px;
				}
				.birthday-table .birthday-table-body tr td:last-child {
					margin-bottom: 0;
				}
				.birthday-table .birthday-table-body tr td:before {
					font-family: inherit;
					font-size: 14px;
					color: #999999;
					line-height: 1.2;
					font-weight: unset;
					position: absolute;
					width: 30%;
					left: 24px;
					top: 0;
				}
				.birthday-table .birthday-table-body tr td:nth-child(1):before {
					content: "Username";
				}
				.birthday-table .birthday-table-body tr td:nth-child(2):before {
					content: "Birthday Date";
				}
				.birthday-table .birthday-table-body tr td:nth-child(3):before {
					content: "Contact";
				}
				.birthday-table .birthday-table-body tr td:nth-child(4):before {
					content: "Joined at";
				}

				.column4,
				.column5,
				.column6 {
					text-align: left;
				}

				.column4,
				.column5,
				.column6,
				.column1,
				.column2,
				.column3 {
					width: 100%;
				}

				.birthday-table-body tr {
					font-size: 14px;
				}
	        }
        
	        @media (max-width: 576px) {
	        	.container-table100 {
	            	padding-left: 15px;
	            	padding-right: 15px;
	          }
	        }
		</style>
		';
}

function compareDates($element1, $element2)
{
    return $element1[4] - $element2[4];
}

function parseUsersInfo($data): array
{

    $data_array = array();
    foreach ($data as &$users_info) {
        $users_info = preg_split("/\r\n|\n|\r/", $users_info->post_content);
        array_push($data_array, $users_info);
    }

    return $data_array;
}


function addAgeAndDaysToBirthdate($data_array)
{

    foreach ($data_array as &$users_info) {
        $newDate = date("d-m-Y", strtotime($users_info[2]));
        $users_info[3] = date_diff(date_create($newDate), date_create('now'))->y;
        $users_info[4] = days_to_birth($newDate);
    }

    return $data_array;

}
