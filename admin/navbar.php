<?php
// require_once '../lib/core.php';
// //fetching
// $sql="select * from web_config";
// $res= $conn->query($sql);
// if($res->num_rows > 0)
// {
//     $config=$res->fetch_assoc();
// }
?>
<header class="top-header">
			<nav class="navbar navbar-expand">
				<div class="left-topbar d-flex align-items-center">
					<a href="javascript:;" class="toggle-btn">	<i class="bx bx-menu"></i>
					</a>
				</div>
				<div class="right-topbar ml-auto">
					<ul class="navbar-nav">
					
						<li class="nav-item dropdown dropdown-user-profile">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
								<div class="media user-box align-items-center">
									<div class="media-body user-info">
										<p class="user-name mb-0"><?=$_SESSION['admin_signed_in']?></p>
										<p class="designattion mb-0">Available</p>
									</div>
									<img src="./assets/images/avatars/1.png" class="user-img" alt="user avatar">
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-right">	
									<a class="dropdown-item" href="logout.php"><i
										class="bx bx-power-off"></i><span>Logout</span></a>
							</div>
						</li>
						<li class="nav-item dropdown dropdown-language">
							<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-toggle="dropdown">
								<div class="lang d-flex">
									<div><i class="flag-icon flag-icon-in"></i>
									</div>
									<div><span>En</span>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
			</nav>
</header>