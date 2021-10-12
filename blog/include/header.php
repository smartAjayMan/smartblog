<?php session_start(); ?>
<header>
        <div class="nav-main bc-gray">
            <div class="nav-secondary">
                <div class="nav-title">
                    <h2 class="tie-name"><a href="<?php echo(BASE_URL.'/index.php') ?>" class="cr-red">S<span>martAjay</span></a></h2>
                </div>
                <div class="nofication-bell-icon">
                    <span class="numberCount-notify">
                        <b id="notifyCount"></b>
                    </span>
                    <p class="tie">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13%"
                            height="20%" fill="currentColor"
                            id="notification-icon" class="bi bi-bell"
                            viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8
                                1.918l-.797.161A4.002 4.002 0 0 0 4 6c0
                                .628-.134 2.197-.459 3.742-.16.767-.376
                                1.566-.663
                                2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134
                                8.197 12 6.628 12 6a4.002 4.002 0 0
                                0-3.203-3.92L8 1.917zM14.22
                                12c.223.447.481.801.78
                                1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88
                                3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1
                                1.99 0A5.002
                                5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                            </svg>
                        </p>
                        <div class="notification-content"  id="notification-alert-show">
                            <ul>
                                <li class="list-item-mes">
                                    <p class="user-notify-aleter">
                                        <b class="ms-ico-message">Notication</b>
                                        <b class="close-message" id="notification-all-hidden">X</b>
                                    </p>
                                </li>
                                <p id="notify_showed">

                                </p>                       

                            </ul>
                        </div>
                </div>
            </div>
            <div class="search-bar">
               <span class="search-icon-close-show" id="search-show">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi
                    bi-search-show-hidden" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397
                        1.398h-.001c.03.04.062.078.098.115l3.85
                        3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007
                        1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11
                        0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                </span>
                <form action="<?php echo BASE_URL.'search.php' ?>" method="get" class="search-bar-wrapper">
                    <span class="search-exists-icon">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16"
                            fill="currentColor" class="bi
                            bi-arrow-left-short" viewBox="0 0 16
                            16">
                            <path fill-rule="evenodd" d="M12 8a.5.5
                                0 0 1-.5.5H5.707l2.147 2.146a.5.5 0
                                0 1-.708.708l-3-3a.5.5 0 0 1
                                0-.708l3-3a.5.5 0 1 1 .708.708L5.707
                                7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                        </span>
                        <input id="search" type="search" name="query"  placeholder="search...">
                        <span class="search-icon-submit">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16"
                                fill="currentColor" class="bi
                                bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5
                                    0 1 0-1.397
                                    1.398h-.001c.03.04.062.078.098.115l3.85
                                    3.85a1 1 0 0 0
                                    1.415-1.414l-3.85-3.85a1.007
                                    1.007 0 0 0-.115-.1zM12
                                    6.5a5.5 5.5 0 1 1-11 0 5.5
                                    5.5 0 0 1 11 0z" />
                                </svg>
                        </span>
                </form>
            </div>
           <div class="user-controller">

           <?php  if (isset($_SESSION['logining']) && $_SESSION['logining'] === true): ?>
           <!-- login showing -->
            <p id="n_user_id" data-n_user_id="<?php echo $_SESSION['id'] ?>"></p>
           
               <div class="user-icon-set">
                 <a href="<?php echo(BASE_URL.'/logged/posts/dashboard.php') ?>">
                  <?php if (!empty($_SESSION['images'])): ?>
                     <img class="icon-log-user" src="<?php echo(BASE_URL. '/images/'.$_SESSION['images']) ?>">
                  <?php else: ?>
                     <div class="icon-log-user" style="text-transform: capitalize;">
                        <?php if (!empty($_SESSION['channel'])) : ?>
                        <!-- channel available -->
                            <?php echo substr($_SESSION['channel'], 0, 1); ?>
                        <?php else: ?>
                        <!-- channel not Available -->
                            <?php echo substr($_SESSION['username'], 0, 1); ?>
                        <?php endif; ?>
                     </div>  
                  <?php endif; ?>
                 </a>
               </div>
           <?php else: ?>
           <!-- not login showing -->
                <div class="user-many-controller">
                    <button type="submit" class="login-logo">
                        <a href="<?php echo(BASE_URL. '/login.php') ?>">Login</a>
                    </button>
                </div>
                <div class="user-many-controller">
                    <button type="submit" class="signup-logo">
                        <a href="<?php echo(BASE_URL. '/signup.php') ?>">Signup</a>
                    </button>
                </div> 

           <?php endif; ?>
             
               
           </div>
        </div>
 </header>
 <script src="<?php echo BASE_URL.'/blog/style/jQuery/jquery-3.6.0.min.js' ?>"></script>
 <script>
    $(document).ready(function () {
        let n_user_id = $('#n_user_id').data('n_user_id');
        function loadPage() {
            // fetch notification...
            $.ajax({
                url : "<?php echo BASE_URL.'/controller/notification.php' ?>",
                method : "POST",
                data : {n_user_id:n_user_id},
                success : function (data) {
                    if (n_user_id !== undefined) {                        
                        $('#notify_showed').html(data);                    
                    }else{
                        $('#notify_showed').html('<b class="cr-red">Warning: </b> Notification Showing For Please Login...');
                    }
                }
            });
            // counting notification...
            $.ajax({
                url : "<?php echo BASE_URL.'/controller/notifyCount.php' ?>",
                method : "POST",
                data : {n_user_id:n_user_id},
                success : function (data) {
                res = JSON.parse(data);
                $('#notifyCount').text(res.count);

                }
            });
        }
        loadPage();
        $(document).on('click', '.notification-img', function (e) {
            e.preventDefault();
           let notify = $(this);
           let multi_id = $(this).data('status');
           let user_id = $('#n_user_id').data('n_user_id');
           if (notify.hasClass('removing')) {
              action = 'remove'; 
           }else if (notify.hasClass('updating')) {
              action = 'update'; 
           }
           $.ajax({
               url : "<?php echo BASE_URL.'/controller/notification.php' ?>",
               method : "POST",
               data : {
                      multi_id:multi_id, 
                      user_id : user_id, 
                      action : action   
                 },
               success : function (data) {
                   if (data == 1) {
                       loadPage();
                   }
               }
           });
        });
        // search input & Output
        $(document).on('click', '.search-icon-submit', function (e) {
            e.preventDefault();
            let search = $('#search').val();
            if (search !== '') {
              window.location.href = "<?php echo BASE_URL.'search.php?query=' ?>"+search;
            }
            
        });
    });
 </script>
