
  <style media="screen">
  .pac-container {
      z-index: 1051 !important;
  }

  .left-controller-option .hide{
    display: none;
  }

  .profile-image .inner-image .status_online{
    height: 20px;
    width: 20px;
    background: #4CAF50;
    position: absolute;
    border-radius: 20px;
    border: 2px solid #fff;
    top: 8.78em;
    left: 4.2em;
  }

  .profile-image .inner-image .status_offline{
    height: 20px;
    width: 20px;
    background: #a0a0a0;
    position: absolute;
    border-radius: 20px;
    border: 2px solid #fff;
    top: 8.78em;
    left: 4.2em;
  }

  </style>
  <div class="container">
    <div class="row mt-2">
      <div class="col-md-12">
        <h3 class="h5">
          <?php if ($this->session->flashdata('profile_updated')) { ?>
              <span class="text-success text-h3"><?= $this->session->flashdata('profile_updated') ?></span>
          <?php } ?>
           <?php if ($this->session->flashdata('error-profile')) { ?>
              <span class="text-danger text-h3"><?= $this->session->flashdata('error-profile') ?></span>
          <?php } ?>
          <?php echo validation_errors(); ?>
        </h3>
        <div class="jumbotron jumbotron-fluid jumbo-style" style="height: 13em;background-image:url('<?php if(isset($users['cover_image'])) {echo './assets/images/covers/'.$users['cover_image'];} ?>'); background-size: cover; background-repeat: no-repeat; background-position: center; background-attachment: static;">
          <div class="container">
              <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>
              <?php else: ?>
                <a href="javascript:void(0)" class="d-flex justify-content-start"><i class="fa fa-camera" aria-hidden="true" data-toggle="modal" data-target="#coveruploadmodal"></i></a>
              <?php endif; ?>
          </div>
        </div>
        <!-- update cover image -->
           <div class="modal fade" id="coveruploadmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h4 class="modal-title w-100 font-weight-bold">Upload profile cover</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body mx-3">
                  <section>
                    <div class="container">
                      <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                         <form id="coverform" action="<?php echo site_url("profile/upload"); ?>" enctype="multipart/form-data" method="post">
                          <div class="row align-items-center">
                            <div class="col mt-4">
                              <input type="file" onchange="return TpValidate();" id="file" name="image" class="form-control" value="" placeholder="Select a pictute" accept=".jpg, .png, .gif, .jpeg" required>
                            </div>
                          </div>
                          <div class="row justify-content-start mt-4">
                            <div class="col">
                              <button class="btn btn-primary btn-block mt-1 mb-4" id="" data-disable-with="Updating data...">Update</button>
                            </div>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
                  </div>
              </div>
            </div>
          </div>
        <!-- end update cover image -->
      </div>
      <div class="profile-image">
          <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>

          <?php else: ?>
            <a href="javascript:void(0)" class="d-flex justify-content-center camera-hover">
              <i class="fa fa-camera" aria-hidden="true" data-toggle="modal" data-target="#profileuploadmodal"></i>
            </a>
          <?php endif; ?>

        <div class="inner-image">
          <?php if ($users['user_id'] == $this->session->userdata('user_id') && $users['username'] == $this->session->userdata('username')): ?>
            <span class="status_online"></span>
          <?php else: ?>
            <?php if ($users['online'] == 1): ?>
              <span class="status_online" title="<?php echo $users['firstname']; ?> is online"></span>
            <?php else: ?>
              <span class="status_offline" title="<?php echo $users['firstname']; ?> is offline"></span>
            <?php endif; ?>
          <?php endif; ?>
          <?php if (!empty($users['image'])): ?>
            <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$users['image']; ?>" class="rounded" alt='profile'>
          <?php else: ?>
            <img src="<?php echo base_url(); ?>assets/blank-profile.png" class="rounded" alt='profile'>
          <?php endif; ?>
        </div>

        <!-- update profile image -->
           <div class="modal fade" id="profileuploadmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
          aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <h4 class="modal-title w-100 font-weight-bold">Upload profile picture</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body mx-3">
                  <section>
                    <div class="container">
                      <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                         <form id="" action="<?php echo site_url("profile/uploadProfile"); ?>" enctype="multipart/form-data" method="post">
                          <div class="row align-items-center">
                            <div class="col mt-4">
                              <input type="file" onchange="return TpValidateProfile();" id="pro-picture" name="image" class="form-control" value="" placeholder="Select a pictute" accept=".jpg, .png, .gif, .jpeg" required>
                            </div>
                          </div>
                          <div class="row justify-content-start mt-4">
                            <div class="col">
                              <button class="btn btn-primary btn-block mt-1 mb-4" id="" data-disable-with="Updating data...">Update</button>
                            </div>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
                  </div>
              </div>
            </div>
          </div>
        <!-- end update profile image -->

      </div>
      <div class="perso-data">
        <h2 class="h5"><?php echo add3dots($users['firstname'], "...", 12); ?> <span></span> <?php echo add3dots($users['lastname'], "...", 7); ?><span style="font-size:15px;color: #007bff;padding-left: 4px;"><?php echo "@".$users['username'] ; ?></span> <span class="text-success h6">Joined: <?php echo joined($users['acount_created_at']); ?></span></h2>
          <span><strong class="h5">Gender:</strong> <?php echo $users['gender']; ?></span>
          <span><strong class="h5 ml-2">Born:</strong> <?php echo $users['dob']; ?></span>
      </div>
      <div class="activity-starts">
        <!--write activity info posts likes crushes supercrushes ratings-->
        <div class="stats">
        	<div>
            	<strong>Posts</strong>
                <?php if ($num_posts == 0): ?>
                  0
                <?php else: ?>
                  <?php echo $num_posts; ?>
                <?php endif; ?>
            </div>
            <div>
            	<strong>Friends</strong>
                <?php if (getfriends($users['user_id'], false) == 0): ?>
                  0
                <?php else: ?>
                  <?php echo getfriends($users['user_id'], false); ?>
                <?php endif ?>
            </div>
            <div>
            	<strong>Saved posts</strong>
                <?php if ($saved_post_num == 0): ?>
                  0
                <?php else: ?>
                  <?php echo $saved_post_num; ?>
                <?php endif ?>
            </div>
          <!--   <div>
            	<strong>Crushes</strong>
                0
            </div>
            <div>
            	<strong>Rating</strong>
                0
            </div> -->
        </div>
      </div>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="account" role="tabpanel">
          <div class="contact-info-card">
            <!--write contact info.. email phone address-->
            <div class="contact-card-customize">
              <h1 class="h4">Contact information and Hobbies</h1>
              <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>

              <?php else: ?>
                <span class="edit-contact pull-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#updatepersonal" data-whatever="@mdo"><i class="fa fa-pencil-square fa-2x"></i></a></span>
              <?php endif; ?>

              <hr>
              <div class="">
                <span><strong>Cell Number:</strong></span>
                <?php if (!empty($users['cellno'])): ?>
                  <p><?php echo $users['cellno']; ?></p>
                <?php else: ?>
                  <p><a href="#" class="text-disabled">Please insert your number</a></p>
                <?php endif; ?>
              </div>
              <div class="">
                <span><strong>Email:</strong></span>
                <p><?php echo $users['email']; ?></p>
              </div>
              <div class="">
                <span><strong>Address:</strong></span>
                <p><?php echo $users['address']; ?></p>
              </div>
              <div class="">
                <span><strong>Hobbies:</strong></span>
                <?php if (!empty($users['hobby'])): ?>
                  <p><?php echo $users['hobby']; ?></p>
                <?php else: ?>
                  <p>No hobbies?</p>
                <?php endif; ?>
              </div>
            </div>
            <!-- update personal infor -->
             <div class="modal fade" id="updatepersonal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Update Personal information and hobby <br><span class="h6 text-primary">All fields are required exept Hobby</span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <section>
                      <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                            <form class="" action="<?php echo site_url("profile/edit"); ?>" method="post">
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="text" name="firstname" class="form-control" maxlength="32" value="<?php if(isset($users['firstname'])) {echo $users['firstname'];} ?>" required>
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="text" name="lastname" class="form-control" maxlength="32" value="<?php if(isset($users['lastname'])) {echo $users['lastname'];} ?>" required>
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="email" name="email" class="form-control" maxlength="80" value="<?php if(isset($users['email'])) {echo $users['email'];} ?>" required>
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <select class="browser-default custom-select" name="gender" required>
                                  <option selected><?php if(isset($users['gender'])) {echo $users['gender'];} ?></option>
                                  <option value="Female">Female</option>
                                  <option value="Male">Male</option>
                                  <option value="Agender">Agender</option>
                                  <option value="Androgyne">Androgyne</option>
                                  <option value="Androgynous">Androgynous</option>
                                  <option value="Bigender">Bigender</option>
                                  <option value="Cis">Cis</option>
                                  <option value="Cisgender">Cisgender</option>
                                  <option value="Cis Female">Cis Female</option>
                                  <option value="Trans Female">Trans Female</option>
                                  <option value="Trans* Female">Trans* Female</option>
                                  <option value="Trans Male">Trans Male</option>
                                  <option value="Trans* Male">Trans* Male</option>
                                  <option value="Trans Man">Trans Man</option>
                                  <option value="Trans* Man">Trans* Man</option>
                                  <option value="Trans Person">Trans Person</option>
                                  <option value="Two-Spirit">Two-Spirit</option>
                                </select>
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="text" name="hobby" class="form-control" maxlength="300" value="<?php if(isset($users['hobby'])) {echo $users['hobby'];} ?>" placeholder="hobby">
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <textarea name="address" id="autocomplete" class="form-control" onFocus="geolocate()" required><?php if(isset($users['address'])) {echo $users['address'];} ?></textarea>
                              </div>
                            </div>
                            <div class="row justify-content-start mt-4">
                              <div class="col">
                                <button class="btn btn-primary btn-block mt-1 mb-4" data-disable-with="Updating data...">Update</button>
                              </div>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>
            <!-- end personal infor -->
          </div>
          <div class="user-bio">
            <div class="profile card">
                <div class="profile-body">
                      <div class="">
                          <h1 class="h4">Bio</h1>
                          <?php if (!empty($users['job_name'])): ?>
                            <span><strong>Job:</strong> <?php echo $users['job_name']; ?></span>
                          <?php else: ?>
                            <span><strong>Job:</strong> job name</span>
                          <?php endif; ?>

                          <?php if (!empty($users['job_title'])): ?>
                            <span><strong>Position:</strong> <?php echo $users['job_title']; ?></span>
                          <?php else: ?>
                            <span><strong> Position:</strong> position name</span>
                          <?php endif; ?>
                          <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>

                          <?php else: ?>
                            <span class="edit-contact pull-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#biojobModal"><i class="fa fa-pencil-square fa-2x"></i></a></span>
                          <?php endif; ?>

                          <hr>
                          <?php if (!empty($users['bio'])): ?>
                            <p><?php echo getPostLink(nl2br($users['bio'])); ?></p>
                          <?php else: ?>
                            <h3>Your bio</h3>
                          <?php endif; ?>
                      </div>
              </div>
            </div>
            <div class="modal fade" id="biojobModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel">Update job, position and bio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <section>
                      <div class="container">
                        <div class="row justify-content-center">
                          <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                            <form class="" action="<?php echo site_url("profile/update_bio"); ?>" method="post">
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="text" name="job" class="form-control" value="<?php if(isset($users['job_name'])) {echo $users['job_name'];} ?>" placeholder="Job name">
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <input type="text" name="position" class="form-control" value="<?php if(isset($users['job_title'])) {echo $users['job_title'];} ?>" placeholder="Job position">
                              </div>
                            </div>
                            <div class="row align-items-center">
                              <div class="col mt-4">
                                <textarea name="bio" class="form-control" maxlength="500" placeholder="Your bio here.."><?php if(isset($users['bio'])) {echo $users['bio'];} ?></textarea>
                              </div>
                            </div>
                            <div class="row justify-content-start mt-4">
                              <div class="col">
                                <button class="btn btn-primary btn-block mt-1 mb-4" data-disable-with="Updating data...">Update</button>
                              </div>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>
            <?php else: ?>
               <div class="">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                    aria-selected="true">Posts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                    aria-selected="false">Liked posts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                    aria-selected="false">Saved posts</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="bookmarks-tab" data-toggle="tab" href="#bookmark" role="tab" aria-controls="bookmark"
                    aria-selected="false">bookmarks</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="" style="width: 500px; max-width:500px;  height: auto;">
                  <?php if ($num_posts == 0): ?>
                      You don't have post/s yet...
                    <?php else: ?>
                      <?php foreach ($user_posts as $myPosts): ?>
                      <section>
                        <div class="container">
                          <div class="row justify-content-start">
                            <div class="col col-xl-12">
                              <div class="card card-body mb-3">
                                  <h4 class="card-title"></h4>
                                  <div class="mb-3 image-user" style="margin-top: -1em;">
                                    <a href="<?php echo base_url(); ?>profile?username=<?php echo $this->session->userdata('username'); ?>">
                                      <?php if (!empty($myPosts['profile_pic'])): ?>
                                        <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$myPosts['profile_pic']; ?>" width="40" height="40" alt="profile pic">
                                      <?php else: ?>
                                        <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                      <?php endif; ?>
                                    </a>
                                    <a href="<?php echo base_url(); ?>profile?username=<?php echo $this->session->userdata('username'); ?>; ?>" class="name-position"><?php echo $myPosts['firstname']; ?></a><br>
                                    <a href="" class="time-position"><?php echo get_time_ago($myPosts['posted_at']); ?></a>

                                    <a href="#" class="a-move pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h fa-lg"></i></a>
                                    <div class="dropdown-menu">
                                      <?php if ($this->session->userdata('user_id') != $myPosts['user_id']): ?>
                                        <a class="dropdown-item" href="#"><i class="fa fa-bug"></i> Report post</a>
                                      <?php else: ?>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>/posts/edit/<?php echo $myPosts['post_id'];?>"><i class="fa fa-pencil"></i> Edit post</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>/posts/deleteFromU/<?php echo $myPosts['post_id'];?>" data-toggle="modal" data-target="#deleteModal<?php echo $myPosts['post_id'];?>">
                                          <i class="fa fa-trash" aria-hidden='true'></i> Delete post
                                        </a>
                                      <?php endif; ?>
                                    </div>
                                    <!-- Basic dropdown -->
                                    <span class="pull-right">
                                      <a href="" class="mr-4">
                                        <i class="fa fa-bookmark fa-lg" aria-hidden="true"></i>
                                      </a>
                                      <a href="#">
                                        <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                                      </a>
                                    </span>
                                  </div>
                                  <p class="card-text" style="margin-bottom: .1rem;">
                                      <?php echo getPostLink(nl2br($myPosts['post'])); ?>
                                  </p>
                                  <div class="feed-body">
                                   <?php if (!empty($myPosts['post_image'])): ?>
                                     <div class="post-image-style">
                                       <img src="<?php echo base_url();?><?php echo 'assets/images/postimages/'.$myPosts['post_image']; ?>" width="570" height="300" alt="post image">
                                     </div>
                                   <?php endif; ?>
                                 </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  <?php endforeach; ?>
                  <?php endif ?>
                 </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">one</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <?php if ($saved_post_num == 0): ?>
                      You don't have saved post/s yet...
                    <?php else: ?>
                      <?php foreach ($saved_post as $mySavedPosts): ?>
                      <section>
                        <div class="container">
                          <div class="row justify-content-start">
                            <div class="col-12 col-xl-7">
                              <div class="card card-body mb-3">
                                  <h4 class="card-title"></h4>
                                  <div class="mb-3 image-user" style="margin-top: -1em;">
                                    <a href="<?php echo base_url(); ?>profile?username=<?php echo $mySavedPosts['username']; ?>">
                                      <?php if (!empty($mySavedPosts['profile_pic'])): ?>
                                        <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$mySavedPosts['profile_pic']; ?>" width="40" height="40" alt="profile pic">
                                      <?php else: ?>
                                        <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                      <?php endif; ?>
                                    </a>
                                    <a href="<?php echo base_url(); ?>profile?username=<?php echo $mySavedPosts['username']; ?>" class="name-position"><?php echo $mySavedPosts['firstname']; ?></a><br>
                                    <a href="" class="time-position"><?php echo get_time_ago($mySavedPosts['posted_at']); ?></a>

                                    <a href="#" class="a-move pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h fa-lg"></i></a>
                                    <div class="dropdown-menu">
                                      <?php if ($users['user_id'] != $mySavedPosts['user_id']): ?>
                                        <a class="dropdown-item" href="#"><i class="fa fa-bug"></i> Report post</a>
                                      <?php else: ?>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>/posts/edit/<?php echo $mySavedPosts['post_id'];?>"><i class="fa fa-pencil"></i> Edit post</a>
                                        <a class="dropdown-item" href="<?php echo base_url(); ?>/posts/deleteFromU/<?php echo $mySavedPosts['post_id'];?>" data-toggle="modal" data-target="#deleteModal<?php echo $mySavedPosts['post_id'];?>">
                                          <i class="fa fa-trash" aria-hidden='true'></i> Delete post
                                        </a>
                                      <?php endif; ?>
                                    </div>
                                    <!-- Basic dropdown -->
                                    <span class="pull-right">
                                      <a href="" class="mr-4">
                                        <i class="fa fa-bookmark fa-lg" aria-hidden="true"></i>
                                      </a>
                                      <a href="#">
                                        <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                                      </a>
                                    </span>
                                  </div>
                                  <p class="card-text" style="margin-bottom: .1rem;">
                                      <?php echo getPostLink(nl2br($mySavedPosts['post'])); ?>
                                  </p>
                                  <div class="feed-body">
                                   <?php if (!empty($mySavedPosts['post_image'])): ?>
                                     <div class="post-image-style">
                                       <img src="<?php echo base_url();?><?php echo 'assets/images/postimages/'.$mySavedPosts['post_image']; ?>" width="570" height="300" alt="post image">
                                     </div>
                                   <?php endif; ?>
                                 </div>
                              </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  <?php endforeach; ?>
                  <?php endif ?>
                </div>
                <div class="tab-pane fade" id="bookmark" role="tabpanel" aria-labelledby="contact-tab">four</div>
              </div>
            </div>
            <?php endif ?>

        </div>
        <div class="tab-pane fade" id="favourite" role="tabpanel">
          <div class="content-wraper-out-favourite">
            <div class="content-wraper-inside">
              <h1 class="h4">My favourite stuff</h1>
              <span class="edit-contact pull-right"><a href="javascript:void(0)" data-toggle="modal" data-target="#favouriteModal"><i class="fa fa-pencil-square fa-2x"></i></a></span>
                      <div class="modal fade" id="favouriteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <!--Content-->
                    <div class="modal-content">
                      <!--Header-->
                      <div class="modal-header text-center">
                        <h4 class="modal-title black-text py-2">Update favourites</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true" class="text-danager">&times;</span>
                        </button>
                      </div>

                      <!--Body-->
                      <section>
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-8 col-xl-10">
                              <form class="" action="<?php echo site_url("profile/favourite"); ?>" method="post">
                              <div class="row align-items-center">
                                <div class="col mt-4">
                                  <input type="text" name="music" class="form-control" value="<?php if(isset($users['music'])) {echo $users['music'];} ?>" placeholder="Music">
                                </div>
                              </div>
                              <div class="row align-items-center mt-4">
                                <div class="col">
                                  <input type="text" name="movies" class="form-control" value="<?php if(isset($users['movies'])) {echo $users['movies'];} ?>" placeholder="Movies">
                                </div>
                              </div>
                              <div class="row align-items-center mt-4">
                                <div class="col">
                                  <input type="text" name="books" class="form-control" value="<?php if(isset($users['books'])) {echo $users['books'];} ?>" placeholder="Books">
                                </div>
                              </div>
                              <div class="row align-items-center mt-4">
                                <div class="col">
                                  <input type="text" name="animals" class="form-control" value="<?php if(isset($users['animals'])) {echo $users['animals'];} ?>" placeholder="Animals">
                                </div>
                              </div>
                              <div class="row justify-content-start mt-4">
                                <div class="col">
                                  <button type="submit" class="btn btn-primary btn-block mt-1 mb-4" data-disable-with="Updating data...">Update</button>
                                </div>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </section>


                    </div>
                    <!--/.Content-->
                  </div>
                </div>
                  <hr>
                  <div class="card card-cascade">
                    <!-- Card image -->
                    <div class="view view-cascade back-image">
                      <div class="view view-cascade Darkened-back">
                        <h4 class="font-weight-bold card-title text-center text-white mt-4">Music</h4>
                      </div>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                      <?php if (!empty($users['music'])): ?>
                        <h5 class="pink-text pb-2 pt-1"><?php echo $users['music']; ?></h5>
                      <?php else: ?>
                        <h5 class="pink-text pb-2 pt-1">What is your favourite music</h5>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="card card-cascade">
                    <!-- Card image -->
                    <div class="view view-cascade back-image-movie">
                      <div class="view view-cascade Darkened-back">
                        <h4 class="font-weight-bold card-title text-center text-white mt-4">Movies</h4>
                      </div>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                      <?php if (!empty($users['movies'])): ?>
                        <h5 class="pink-text pb-2 pt-1"><?php echo $users['movies']; ?></h5>
                      <?php else: ?>
                        <h5 class="pink-text pb-2 pt-1">What are your favourite movies</h5>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="card card-cascade">
                    <!-- Card image -->
                    <div class="view view-cascade back-image-animal">
                      <div class="view view-cascade Darkened-back">
                        <h4 class="font-weight-bold card-title text-center text-white mt-4">Animals</h4>
                      </div>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                      <?php if (!empty($users['animals'])): ?>
                        <h5 class="pink-text pb-2 pt-1"><?php echo $users['animals']; ?></h5>
                      <?php else: ?>
                        <h5 class="pink-text pb-2 pt-1">What are your favourite animals</h5>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="card card-cascade">
                    <!-- Card image -->
                    <div class="view view-cascade back-image-book">
                      <div class="view view-cascade Darkened-back">
                        <h4 class="font-weight-bold card-title text-center text-white mt-4">Books</h4>
                      </div>
                    </div>
                    <!-- Card content -->
                    <div class="card-body card-body-cascade">
                      <?php if (!empty($users['books'])): ?>
                        <h5 class="pink-text pb-2 pt-1"><?php echo $users['books']; ?></h5>
                      <?php else: ?>
                        <h5 class="pink-text pb-2 pt-1">What are your favourite books</h5>
                      <?php endif; ?>
                    </div>
                  </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="manage" role="tabpanel">
          <div class="content-wraper-out-manage">
            <div class="content-wraper-inside">
              <h1 class="h4">Manage posts</h1>
              <span class="edit-contact pull-right"><a href="javascript:void(0)"><i class="fa fa-pencil-square fa-2x"></i></a></span>
              <hr>
              <div class="manage-content">

              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="friends" role="tabpanel">
          <div class="content-wraper-out-friends">
            <div class="content-wraper-inside">
              <h1 class="h4">Friends</h1>
              <span class="edit-contact pull-right"><a href="javascript:void(0)"><i class="fa fa-users fa-2x"></i></a></span>
              <hr>
              <div class="friends-content">
                <?php if (getfriends($users['user_id'], false) == 0): ?>
                  You don't have friends...
                <?php else: ?>
                  <?php foreach (getfriends($users['user_id'], true) as $friends): ?>
                    <div class="col-12 col-xl-12">
                      <div class="friend-dt-style">
                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $friends[0]['username']; ?>">
                        <?php if (!empty($friends[0]['image'])): ?>
                          <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$friends[0]['image']; ?>" width="40" height="40" alt="profile pic">
                        <?php else: ?>
                          <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                        <?php endif; ?>
                      </a>
                      <a href="javascript:void(0)" class="friend-name-style"><?php echo $friends[0]['firstname'] ." ". $friends[0]['lastname']; ?></a> <br> <span class="username-style"><?php echo "@".$friends[0]['username']; ?></span>
                      <a href="" class="friend-since-style"></a>
                      <ul class="ul-focus">
                        <li style="padding-top: 5px;color: #007bffa6;font-style: oblique;">
                          <?php echo mutual_counter(mutualFriends($users['user_id'], $friends[0]['user_id'])); ?>
                        </li>
                        <li>
                          <a href="<?php echo base_url(); ?>profile?u=<?php echo $friends[0]['username']; ?>" class="btn btn-labeled btn-primary">
                            <span class="btn-label"><i class="fa fa-external-link"></i></span>
                            Visit friend's profile
                          </a>
                        </li>
                        <li>
                          <button class="btn btn-labeled btn-danger" onclick="unfriend('<?php echo $friends[0]['user_id']; ?>')">
                            <span class="btn-label"><i class="fa fa-user-times"></i></span>
                            un-friend
                          </button>
                        </li>
                      </ul>
                        <a href="" class="pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="position: relative;top: -4em;">
                            <i class="fa fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu" style="max-width: 30%">
                          <p class="p-1" style="margin-top: -5px;margin-bottom: -5px;margin-left: .5rem;">
                            You and <?php echo $friends[0]['firstname']; ?> have been friends for <?php echo friend_for_period($friends[0]['friends_since']); ?>
                          </p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach ?>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="match" role="tabpanel">
          <div class="content-wraper-out-friends">
            <div class="content-wraper-inside">
              <h1 class="h4">All friend requests you have sent</h1>
              <span class="edit-contact pull-right"><a href="javascript:void(0)"><i class="fa fa-user-plus fa-2x"></i></a></span>
              <hr>
              <div class="friends-content">
                <?php if (getfriend_requests($users['user_id'], false) == 0): ?>
                  You haven't sent any friend requests...
                <?php else: ?>
                  <?php foreach (getfriend_requests($users['user_id'], true) as $friendRequest): ?>
                    <div class="col-12 col-xl-12">
                      <div class="friend-dt-style">
                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $friendRequest[0]['username']; ?>">
                        <?php if (!empty($friendRequest[0]['image'])): ?>
                          <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$friendRequest[0]['image']; ?>" width="40" height="40" alt="profile pic">
                        <?php else: ?>
                          <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                        <?php endif; ?>
                      </a>
                      <a href="javascript:void(0)" class="friend-name-style"><?php echo $friendRequest[0]['firstname'] ." ". $friendRequest[0]['lastname']; ?></a> <br> <span class="username-style"><?php echo "@".$friendRequest[0]['username']; ?></span>
                      <a href="" class="friend-since-style"></a>
                      <ul class="ul-focus">
                        <li>
                          <a href="javascript:void(0)" class="btn btn-labeled btn-light disabled">
                            <span class="btn-label"><i class="fa fa-user"></i></span>
                            Freind-request sent
                          </a>
                        </li>
                        <li>
                          <button class="btn btn-labeled btn-danger" onclick="cancelfriendRequest('<?php echo $friendRequest[0]['user_id']; ?>')">
                            <span class="btn-label"><i class="fa fa-user-times"></i></span>
                            Cancel friend-request
                          </button>
                        </li>
                      </ul>
                      </div>
                    </div>
                  <?php endforeach ?>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if ($this->session->userdata('user_id') != $users['user_id']): ?>
          <div class="pull-right left-controller-option">
            <div class="card-size-resize">
              <!--col-md-3 col-xl-3-->
               <div class="card" style="padding: 10px 0px;">
                   <div class="">
                       <div class="col text-center mb-3">
                         <?php
                            if (is_already_friends($this->session->userdata('user_id'), $users['user_id'])) {
                              echo '<a class="btn btn-primary white-text change_text" style="width:100%;" onclick="unfriend('.$users['user_id'].')">
                                Friends
                              </a>';
                            }elseif (i_am_sender($this->session->userdata('user_id'), $users['user_id'])) {
                              echo '<a class="btn btn-danger white-text" style="width:100%;" onclick="cancelfriendRequest('.$users['user_id'].')">
                                Cancel friend request
                              </a>';
                              echo '<a class="btn btn-light white-text disabled" style="width:100%;">
                                Friend request sent
                              </a>';
                            }elseif (i_am_receiver($this->session->userdata('user_id'), $users['user_id'])) {
                              echo '<a class="btn btn-primary white-text" style="width:100%;" onclick="addfriend('.$users['user_id'].')">
                                Accept
                              </a>';
                              echo "Or";
                              echo '<a class="btn btn-danger white-text" style="width:100%;" onclick="cancelfriendRequest('.$users['user_id'].')">
                                Ignore
                              </a>';
                            }else {
                              echo '<a class="btn btn-primary white-text" style="width:100%;" onclick="sendfriendRequest('.$users['user_id'].')">
                                Send friend request
                              </a>';
                            }
                          ?>
                       </div>
                     <div class="col text-center">
                       <?php if (following_or_not($this->session->userdata('user_id'), $users['user_id'])): ?>
                         <span class="unfollow" onclick="return">Unfollow</span>
                         <span class="follow hide btn btn-primary" style="width:100%;" onclick="return">Follow</span>
                       <?php else: ?>
                         <span class="follow btn btn-primary" style="width:100%;" onclick="return">Follow</span>
                         <span class="unfollow hide" onclick="return">Unfollow</span>
                       <?php endif; ?>
                     </div>

                     <div class="col text-center">
                       <p>You have <?php echo mutualFriends($this->session->userdata('user_id'), $users['user_id']); ?> Mutual friends</p>
                     </div>
                   </div>
                </div>
              </div>
            </div>
      <?php else: ?>
      <div class="pull-right left-controller-option">
        <div class="card-size-resize">
          <!--col-md-3 col-xl-3-->
           <div class="card">
               <div class="card-header">
                   <h5 class="card-title mb-0">Information</h5>
               </div>

               <div class="list-group list-group-flush" role="tablist">
                   <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account" role="tab">
                     Default
                   </a>
                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#friends" role="tab">
                     Friends (<?php if(getfriends($users['user_id'], false) == 0){ echo '0'; }else{echo getfriends($users['user_id'], false);} ?>)
                   </a>
                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#match" role="tab">
                     Friend requests (<?php if(getfriend_requests($users['user_id'], false) == 0){ echo '0'; }else{echo getfriend_requests($users['user_id'], false);} ?>)
                   </a>
                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#favourite" role="tab">
                   Favourite
                   </a>
                   <a class="list-group-item list-group-item-action" data-toggle="list" href="#manage" role="tab">
                     Activies
                   </a>
               </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <div class="">
      </div>
    </div>
  </div>

<div class="" style="margin-bottom: 1em;">

</div>
<script>
var placeSearch, autocomplete;

  var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name'
  };

  function initAutocomplete() {
  // Create the autocomplete object, restricting the search predictions to
  // geographical location types.
  autocomplete = new google.maps.places.Autocomplete(
     document.getElementById('autocomplete'), {types: ['geocode']});

  // Avoid paying for data that you don't need by restricting the set of
  // place fields that are returned to just the address components.
  autocomplete.setFields(['address_component']);

  // When the user selects an address from the drop-down, populate the
  // address fields in the form.
  autocomplete.addListener('place_changed', fillInAddress);
  }

  function fillInAddress() {
  // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
     document.getElementById(component).value = '';
     document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details,
    // and then fill-in the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
     var addressType = place.address_components[i].types[0];
     if (componentForm[addressType]) {
       var val = place.address_components[i][componentForm[addressType]];
       document.getElementById(addressType).value = val;
     }
    }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
    if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(function(position) {
       var geolocation = {
         lat: position.coords.latitude,
         lng: position.coords.longitude
       };
       var circle = new google.maps.Circle(
           {center: geolocation, radius: position.coords.accuracy});
       autocomplete.setBounds(circle.getBounds());
     });
    }
  }

  function sendfriendRequest(user_id){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>profile/sendFriendRequest/'+user_id,
        cache: false,
        success: function(request){
          if (request == true) {
            setTimeout(function(){
              location.reload();
            });
          }else {
            alert('Sorry something went wrong, Please try again');
            return false;
          }
        }
    });
  }

  function cancelfriendRequest(user_id){
    if(confirm('Are you sure you want to cancel this freiend-request?')){
      $.ajax({
          type:'POST',
          url:'<?php echo base_url(); ?>profile/cancelFriendRequest/'+user_id,
          cache: false,
          success: function(unrequest){
            if (unrequest == true) {
              setTimeout(function(){
                location.reload();
              });
            }else {
              alert('Sorry something went wrong, Please try again');
              return false;
            }
          }
      });
    }
  }

  function addfriend(user_id){
    $.ajax({
        type:'POST',
        url:'<?php echo base_url(); ?>/profile/acceptFriendRequest/'+user_id,
        cache: false,
        success: function(addfriend){
          if (addfriend == true) {
            setTimeout(function(){
              location.reload();
            });
          }else {
            alert('Sorry something went wrong, Please try again');
            return false;
          }
        }
    });
  }

  function unfriend(user_id){
    if(confirm('Are you sure you want to unfriend this user?')){
      $.ajax({
          url:'<?php echo base_url(); ?>/profile/unfriend/'+user_id,
          type:'POST',
          success: function(unrequest){
            setTimeout(function(){
              location.reload();
            });
          },
          error: function(){
            alert("Sorry something went wrong please try again..");
          }
      });
    }
  }

  function TpValidate(){
    var fileInput = document.getElementById('file');
    var image = fileInput.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (image != "") {
      if(!allowedExtensions.exec(image)){
          alert('Please upload file having extensions .jpeg .jpg .png .gif only.');
          fileInput.value = '';
          return false;
      }
    }

    var fileSize = document.getElementById('file').files[0].size;
    if(fileSize > 2097152){
       alert("Maximum file size exceeded, file size must be less than or equals 2mb");
       fileInput.value = '';
       return false;
    };

    return true;
}

  function TpValidateProfile(){
    var fileInput = document.getElementById('pro-picture');
    var image = fileInput.value;

    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if (image != "") {
      if(!allowedExtensions.exec(image)){
          alert('Please upload file having extensions .jpeg .jpg .png .gif only.');
          fileInput.value = '';
          return false;
      }
    }

    var fileSize = document.getElementById('pro-picture').files[0].size;
    if(fileSize > 2097152){
       alert("Maximum file size exceeded, file size must be less than or equals 2mb");
       fileInput.value = '';
       return false;
    };

    return true;
}

  $(document).ready(function(){
    $('.change_text').hover(function(){
        $(this).text("Unfriend");
    },
    function(){
        $(this).text("Friends");
    });
 });

 </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBRMLF9pK8EoY-wOnp1_N1uZ7pH6fOnlLQ&libraries=places&callback=initAutocomplete"
     async defer></script>
