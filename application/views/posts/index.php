<script src="https://kit.fontawesome.com/1b5939c109.js"></script>
  <?php 
        $current_user = $this->session->userdata('user_id');
        $current_user_address = $this->session->userdata('address');
        $online_friends = get_online_friends($current_user);
   ?>
  <div class="container">
    <div class="row">
      <div class="col text-center mt-3" style="margin-bottom: -18px">
        <?php if ($this->session->flashdata('post_success')) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?= $this->session->flashdata('post_success') ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
           <?php if ($this->session->flashdata('post_errors')) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
             <?= $this->session->flashdata('post_errors') ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div> 
          <?php } ?>
          <span class="text-danger text-h3"><?php echo validation_errors(); ?></span>
      </div>
    </div>


    <div class="row pull-left ml-auto">
      <div class="card" style="width: 17.8rem;position: absolute;left: 5em;top: 10em;">
        <div class="card-body">
          <h5 class="card-title">Online friends</h5>
          <?php if (empty($online_friends)): ?>
            <h6 class="card-title">No online friends</h6>
          <?php else: ?>
          <ul class="online_friend" style="list-style: none;position: relative;left: -2.5em;width: 270px;">
            <?php foreach ($online_friends as $friend): ?>
              <?php foreach ($friend as $key): ?>
                <?php if (is_account_closed($key['user_id'])): ?>
                  <?php else: ?>
                    <li style="margin-bottom: -14px;border-radius: 5px;border: 1px solid #00000012;" title="<?php echo $key['firstname'] . " " . $key['lastname']; ?>">
                      <span class="online_user_images">
                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $key['username']; ?>">
                        <?php if (!empty($key['image'])): ?>
                        <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$key['image']; ?>" width="40" height="40">
                        <?php else: ?>
                          <img src="<?php echo base_url(); ?>assets/blank-profile.png" width="40" height="40" alt="pic">
                        <?php endif ?>
                        </a>
                     </span> 
                    <?php echo add3dots($key['firstname'], "..", 7); ?>
                  </li>
                <?php endif ?>
              <?php endforeach ?>
            <?php endforeach ?>
          </ul>
          <?php endif ?>
        </div>
      </div>
    </div>

   <div class="row pull-right mr-auto">
      <div class="card" style="width: 21.5rem; position: absolute; right: 1.2em; top: 10em;">
        <div class="card-body">
          <h5 class="card-title">Friends Suggestions</h5>
          <hr>
          <ul class="online_friend" style="list-style: none;width: 100%;border-radius: 5px;border: 1px solid #00000012;">
            <?php foreach ($suggested as $users): ?>
              <?php foreach ($users->suggestedUser as $suggest): ?>
                <?php if (is_account_closed($suggest['user_id'])): ?>
                  <?php else: ?>
                  <li style="margin-left: -2em;margin-top: .5em;" title="<?php echo $suggest['firstname'] . " " . $suggest['lastname']; ?>">
                    <span class="online_user_images">
                      <a href="<?php echo base_url(); ?>profile?u=<?php echo $suggest['username']; ?>">
                      <?php if (!empty($suggest['image'])): ?>
                      <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$suggest['image']; ?>" width="40" height="40">
                      <?php else: ?>
                        <img src="<?php echo base_url(); ?>assets/blank-profile.png" width="40" height="40" alt="pic">
                      <?php endif ?>
                      </a>
                   </span> 
                  <?php echo add3dots($suggest['firstname'], "..", 7); ?>
                </li>
                <li style="margin-top: -2.5em;margin-left: 5.5em;">
                  <?php 
                    if (i_am_sender($this->session->userdata('user_id'),$suggest['user_id'])) {
                      echo '<a class="btn btn-light disabled">
                                Friend request sent
                              </a>';
                    }else{
                      echo '<a href="javascript:void(0);" class="btn btn-primary" onclick="sendfriendRequest('.$suggest['user_id'].')">Send friend request</a>';
                    }

                   ?>
                </li>
                <?php endif ?>
              <?php endforeach ?>
            <?php endforeach ?>
          </ul>
        </div>
      </div>
    </div>

      <section class="post-only">
        <div class="container">
          <div class="row justify-content-center">
            <div class="outer-positioning">
              <div class="row align-items-center">
                <div class="post-profile">
                  <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                    <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                      <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                    <?php else: ?>
                      <img src="<?php echo base_url(); ?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                    <?php endif; ?>
                  </a>
                </div>
                <div class="col mt-4">
                  <input type="text" class="form-control-custom" name="" data-toggle="modal" data-target="#postModal" placeholder="Have something in mind...">
                </div>
                <div class="post-camera">
                  <a href="" data-toggle="modal" data-target="#postModal"><i class="fa fa-picture-o"></i></a>
                </div>
              </div>

              <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o"></i> Create a new post</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                        <div class="post-post">
                          <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                            <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                              <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                            <?php else: ?>
                              <img src="<?php echo base_url(); ?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                            <?php endif; ?>
                          </a>
                        </div>
                        <form id="postForm" action="<?php echo site_url("posts/post"); ?>" onsubmit="return TpValidate()" enctype="multipart/form-data" method="post">
                          <textarea name="post_text" class="textareaClass" id="area" placeholder="Write something here..." data-emojiable="true"></textarea>
                          <span aria-hidden="true" title="Remove image.." id="removeimageid" onclick="removeimage()" style="position: absolute; cursor: pointer; display: none;; left: 4em; bottom: 9px; z-index: 1;color: orange;" class="fa fa-times-circle"></span>
                          <img src="" height="" width="" title="Choose different image.." onClick="triggerClick()" id="filepreview" style="display: none; position: relative; top: .5em; left: 3em; width: auto; height: auto; max-height: 140px; max-width: 140px; border-radius: 5px; cursor: pointer;">
                          <div class="file-field" style="position: absolute; bottom: .1em; left: 34.5em;">
                           <div class="d-flex">
                             <div class="after-d-flex">
                               <span class="blue-text"><i style="font-size: 2em;" class="fa fa-picture-o"></i></span>
                               <input type="file" onChange="previewImage(this)" id="file" name="image" accept=".jpg, .png, .gif, .jpeg">
                             </div>
                           </div>
                         </div>
                         <select name="privacy" class="browser-default custom-select" style="position: absolute;margin-top: 1.9em !important; width:30%;">
                          <option selected value="public">Public</option>
                          <option value="private">Private</option>
                        </select>
                      </div>
                      <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
                        <button type="submit" style="width: 30%;" class="btn btn-primary" data-disable-with="Posting...">Post</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </section>

        <div class="mt-3">
         <?php
          //print_r(Addresses($current_user_address,$current_user));
         ?>
        </div>

        <?php foreach($posts as $post) :?>
         <?php if (isMyFriend($this->session->userdata('user_id'), $post['username'])): ?>
          <section class="display_posts_only" id="<?php echo $post['post_id']; ?>">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-12 col-xl-7">
                  <div class="card card-body mb-3">
                      <h4 class="card-title"></h4>
                      <div class="mb-3 image-user" style="margin-top: -1em;">
                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $post['username']; ?>">
                          <?php if (!empty($post['profile_pic'])): ?>
                            <img src="<?php echo base_url(); ?><?php echo 'assets/images/profileimages/'.$post['profile_pic']; ?>" width="40" height="40" alt="profile pic">
                          <?php else: ?>
                            <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                          <?php endif; ?>
                        </a>
                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $post['username']; ?>" class="name-position"><?php echo $post['firstname']; ?> <span style="color: gray; font-size: 12px;"> | @<?php echo $post['username']; ?></span></a><br>
                        <a href="" class="time-position"><?php echo get_time_ago($post['posted_at']); ?></a>

                        <a href="javascript:void(0)" class="a-move pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                        <div class="dropdown-menu">
                          <?php if ($this->session->userdata('user_id') != $post['user_id']): ?>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#reportPostModal<?php echo $post['post_id'];?>">
                              <i class="fa fa-bug"></i> Report post
                            </a>
                          <?php else: ?>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#editModal<?php echo $post['post_id'];?>">
                              <i class="fa fa-pencil"></i> Edit post
                            </a>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="return deletePost('<?php echo $post['post_id'];?>')">
                              <i class="fa fa-trash" aria-hidden='true'></i> Delete post
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#reportPostModal<?php echo $post['post_id'];?>">
                              <i class="fa fa-bug"></i> Report post
                            </a>
                          <?php endif; ?>
                        </div>
                        <!--Report Post-->
                           <div class="modal fade" id="reportPostModal<?php echo $post['post_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-bug"></i> Report this post</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="<?php echo site_url("posts/reportPost/").$post['post_id']; ?>" method="post">
                                    <div class="modal-body">
                                       <div class="container">
                                        <label>Please select a problem you notice about this post</label>
                                          <ul class="ks-cboxtags">
                                            <li><input type="checkbox" name="nudity" id="checkboxOne<?php echo $post['post_id'];?>" value="nudity"><label for="checkboxOne<?php echo $post['post_id'];?>">Nudity</label></li>
                                            <li><input type="checkbox" name="violance" id="checkboxFour<?php echo $post['post_id'];?>" value="Violance"><label for="checkboxFour<?php echo $post['post_id'];?>">Violance</label></li>
                                            <li><input type="checkbox" name="hatespeech" id="checkboxFive<?php echo $post['post_id'];?>" value="hatespeech"><label for="checkboxFive<?php echo $post['post_id'];?>">Hate Speech</label></li>
                                            
                                            <li><input type="checkbox" name="suicide" id="checkboxSeven<?php echo $post['post_id'];?>" value="suicide"><label for="checkboxSeven<?php echo $post['post_id'];?>">Suicide</label></li>
                                            <li><input type="checkbox" name="falsenews" id="checkboxEight<?php echo $post['post_id'];?>" value="falsenews"><label for="checkboxEight<?php echo $post['post_id'];?>">False News</label></li>
                                            <li><input type="checkbox" name="spam" id="checkboxTen<?php echo $post['post_id'];?>" value="spam"><label for="checkboxTen<?php echo $post['post_id'];?>">Spam</label></li>
                                            <li class="ks-selected"><input type="checkbox" name="scam" id="checkboxEleven<?php echo $post['post_id'];?>" value="scam"><label for="checkboxEleven<?php echo $post['post_id'];?>">Scam</label></li>
                                            <li><input type="checkbox" name="drugs" id="checkboxTwelve<?php echo $post['post_id'];?>" value="drugs"><label for="checkboxTwelve<?php echo $post['post_id'];?>">Illegal drug use</label></li>
                                            <li><input type="checkbox" name="offensive" id="checkboxThirteen<?php echo $post['post_id'];?>" value="offensive"><label for="checkboxThirteen<?php echo $post['post_id'];?>">Offensive/insulting(Gender, Race)</label></li>
                                          </ul>

                                        </div>
                                        <div class="form-group">
                                          <label for="exampleFormControlTextarea1">Have additional comment on this report (optional)</label>
                                          <textarea name="report" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Have more to say about this post ?"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                      <button type="submit"  class="btn btn-primary">Report post</button>
                                    </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                        <!-- End report post -->
                        <!-- visibility spell -->
                        <!--Edit Post-->
                            <div class="modal fade" id="editModal<?php echo $post['post_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o"></i> Update post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="post-post">
                                        <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                                          <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                                            <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                                          <?php else: ?>
                                            <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                          <?php endif; ?>
                                        </a>
                                      </div>

                                      <form action="<?php echo site_url("posts/update/").$post['post_id']; ?>" onsubmit="return TpValidateupdate('<?php echo $post['post_id'];?>')" enctype="multipart/form-data" method="post">
                                        <textarea name="post_text" class="textareaClass" id="area_update" placeholder="Write something here..." data-emojiable="true"><?php echo $post['post'];?></textarea>
                                        <?php if (!empty($post['post_image'])): ?>
                                            <img src="<?php echo base_url();?><?php echo 'assets/images/postimages/'.$post['post_image']; ?>" height="1000" width="1000" style="position: relative; top: .5em; left: 2.7em; width: auto; height: auto; max-height: 140px; max-width: 140px; border-radius: 5px;">
                                        <?php endif; ?>
                                        <div class="file-field" style="position: absolute; bottom: .1em; left: 34.5em;">
                                         <div class="d-flex">
                                           <div class="after-d-flex">
                                             <span class="blue-text"><i style="font-size: 2em;" class="fa fa-picture-o"></i></span>
                                             <input type="file" id="fileUpdate" name="image" onchange="TpValidateupdate('<?php echo $post['post_id'];?>')" accept=".jpg, .png, .gif, .jpeg">
                                           </div>
                                         </div>
                                       </div>
                                       <select name="privacy" class="browser-default custom-select" style="position: absolute;margin-top: 1.9em !important; width:30%;">
                                        <option selected value="public"><?php echo $post['privacy']; ?></option>
                                        <option value="private">Public</option>
                                        <option value="private">Private</option>
                                      </select>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-primary">Update post</button>
                                    </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                        <!-- End edit post -->
                        <!-- visibility spell -->
                        <span class="pull-right">
                          <a href="javascript:void(0)" title="Save this post" class="mr-4" onclick="return savedMy('<?php echo $post['post_id'];?>');">
                            <i class="fa fa-bookmark fa-lg" aria-hidden="true"></i>
                          </a>
                          <a href="javascript:void(0)" title="Message the post owner">
                            <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                          </a>
                        </span>

                      </div>
                      <!-- text post -->
                      <p class="card-text">
                          <?php echo getPostLink(nl2br($post['post'])); ?>
                      </p>
                      <div class="feed-body">
                       <?php if (!empty($post['post_image'])): ?>
                         <div class="post-image-style">
                           <img src="<?php echo base_url();?><?php echo 'assets/images/postimages/'.$post['post_image']; ?>" width="540" height="400" alt="post image">
                         </div>
                       <?php endif; ?>
                     </div>
                     <div class="comment_like">
                       <ul class="comment_style">
                         <li class="likes_only" id="load_post<?php echo $post['post_id']; ?>">
                             <?php if (UserLikedOrNot($this->session->userdata('user_id'),$post['post_id'])): ?>
                               <span class="unlike fa fa-heart" onclick="return removeLikes('<?php echo $post['post_id']; ?>')"></span>
                               <span class="like hide fa fa-heart-o" onclick="return addLikes('<?php echo $post['post_id']; ?>')"></span>
                             <?php else: ?>
                               <span class="like fa fa-heart-o" onclick="return addLikes('<?php echo $post['post_id']; ?>')"></span>
                               <span class="unlike hide fa fa-heart" onclick="return removeLikes('<?php echo $post['post_id']; ?>')"></span>
                             <?php endif; ?>

                           <span class="likes_count" style="color: #575757;"><?php echo likesOrLike(format_num($post['like_count'])); ?></span>
                         </li>
                         <li class="comments_only">
                           <span  class="comment-btn" onclick="showComments('<?php echo $post['post_id']; ?>')"><i class="fas fa-comment-alt"></i> <span style="color: #575757;">Comments <?php echo format_num($post['comment_count']); ?></span></span>
                         </li>
                       </ul>

                      <div id="show_hide_comments_<?php echo $post['post_id']; ?>" style="display:none;">
                        <div class="comment_post">
                          <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>" class="user_comment_pic">
                            <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                              <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="p.pic">
                            <?php else: ?>
                              <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="p.pic">
                            <?php endif; ?>
                          </a>
                          <textarea style="resize: none; overflow: hidden;" class="comment_field form-control" id="comment_text_<?php echo $post['post_id']; ?>" autocomplete="off" placeholder="leave a comment..." data-emojiable="true"></textarea>
                           <div class="file-field" style="position: absolute; bottom: 22px; left: 26.4em;">
                             <div class="d-flex">
                               <div class="after-d-flex">
                                 <span class="blue-text"><i style="font-size: 26px;" class="fa fa-picture-o"></i></span>
                                 <input type="file" onchange="validateComment('<?php echo $post['post_id']; ?>')" id="commentfile_<?php echo $post['post_id']; ?>" name="image" accept=".jpg, .png, .gif, .jpeg">
                               </div>
                             </div>
                           </div>
                          <a href="javascript:void(0)" id="btnSubmit<?php echo $post['post_id']; ?>" class="send_post" onclick="return commentodb('<?php echo $post['post_id']; ?>');">
                            <img src="<?php echo base_url();?>assets/send-button.png" width="30" height="30" alt="Comment">
                          </a>
                        </div>
                        <!-- <div id="load_comments<?php echo $post['post_id']; ?>"> -->
                        <!-- comment area -->
                        <?php foreach ($comments as $postCom): ?>
                          <?php if ($postCom['post_id'] == $post['post_id']): ?>
                         <div class="disply_comments">
                            <div class="comment_view_holder" style="border-right: 1px solid gray;background-color: #f000;border-right: 5px solid #2bbbad;border-right-width: 5px;border-right-width: 2px;">
                              <a href="<?php echo base_url(); ?>profile?u=<?php echo $postCom['username']; ?>" class="commented_user_pic mt-2">
                                <?php if (!empty($postCom['profile_pic'])): ?>
                                  <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$postCom['profile_pic']; ?>" width="35" height="35" alt="p.pic">
                                <?php else: ?>
                                  <img src="<?php echo base_url();?>assets/blank-profile.png" width="35" height="35" alt="p.pic">
                                <?php endif; ?>
                              </a>
                              <a href="<?php echo base_url(); ?>profile?u=<?php echo $postCom['username']; ?>" class="commented_username"><?php echo $postCom['firstname']; ?></a>
                              <div class="comment_holder" id="test-hello">
                                <a href="javascript:void(0)" class="a-move-comment pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                <div class="dropdown-menu">
                                  <?php if ($this->session->userdata('user_id') != $postCom['user_id']): ?>
                                    <a class="dropdown-item" href="javascript:void(0)" data-target="<?php echo $postCom['comment_id'];?>">
                                      <i class="fa fa-bug"></i> Report comment
                                    </a>
                                  <?php else: ?>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#editModal<?php echo $postCom['comment_id'];?>">
                                      <i class="fa fa-pencil"></i> Edit comment
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="return deleteComment('<?php echo $postCom['comment_id'];?>','<?php echo $post['post_id']; ?>')">
                                      <i class="fa fa-trash" aria-hidden='true'></i> Delete comment
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#reportCommentModal<?php echo $postCom['comment_id'];?>">
                                      <i class="fa fa-bug"></i> Report comment
                                    </a>
                                  <?php endif; ?>
                                </div>
                                   <!--Report Post-->
                                 <div class="modal fade" id="reportCommentModal<?php echo $postCom['comment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-bug"></i> Report this comment</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <form action="<?php echo site_url("posts/reportComment/").$postCom['comment_id']; ?>" method="post">
                                          <div class="modal-body">
                                             <div class="container">
                                              <label>Please select a problem you notice about this comment</label>
                                                <ul class="ks-cboxtags">
                                                  <li><input type="checkbox" name="nudity" id="checkboxOne<?php echo $postCom['comment_id'];?>" value="nudity"><label for="checkboxOne<?php echo $postCom['comment_id'];?>">Nudity</label></li>
                                                  <li><input type="checkbox" name="violance" id="checkboxFour<?php echo $postCom['comment_id'];?>" value="Violance"><label for="checkboxFour<?php echo $postCom['comment_id'];?>">Violance</label></li>
                                                  <li><input type="checkbox" name="hatespeech" id="checkboxFive<?php echo $postCom['comment_id'];?>" value="hatespeech"><label for="checkboxFive<?php echo $postCom['comment_id'];?>">Hate Speech</label></li>
                                                  
                                                  <li><input type="checkbox" name="suicide" id="checkboxSeven<?php echo $postCom['comment_id'];?>" value="suicide"><label for="checkboxSeven<?php echo $postCom['comment_id'];?>">Suicide</label></li>
                                                  <li><input type="checkbox" name="falsenews" id="checkboxEight<?php echo $postCom['comment_id'];?>" value="falsenews"><label for="checkboxEight<?php echo $postCom['comment_id'];?>">False News</label></li>
                                                  <li><input type="checkbox" name="spam" id="checkboxTen<?php echo $postCom['comment_id'];?>" value="spam"><label for="checkboxTen<?php echo $postCom['comment_id'];?>">Spam</label></li>
                                                  <li class="ks-selected"><input type="checkbox" name="scam" id="checkboxEleven<?php echo $postCom['comment_id'];?>" value="scam"><label for="checkboxEleven<?php echo $postCom['comment_id'];?>">Scam</label></li>
                                                  <li><input type="checkbox" name="drugs" id="checkboxTwelve<?php echo $postCom['comment_id'];?>" value="drugs"><label for="checkboxTwelve<?php echo $postCom['comment_id'];?>">Illegal drug use</label></li>
                                                  <li><input type="checkbox" name="offensive" id="checkboxThirteen<?php echo $postCom['comment_id'];?>" value="offensive"><label for="checkboxThirteen<?php echo $postCom['comment_id'];?>">Offensive/insulting(Gender, Race)</label></li>
                                                </ul>

                                              </div>
                                              <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Have additional comment on this report (optional)</label>
                                                <textarea name="report" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Have more to say about this comment ?"></textarea>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                            <button type="submit"  class="btn btn-primary">Report comment</button>
                                          </div>
                                          </form>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- End report post -->
                                  <!-- visibility spell -->
                                  <p id="commentContent_<?php echo $postCom['comment_id']; ?>">
                                    <?php echo getPostLink(nl2br($postCom['comment'])); ?>
                                  </p>
                                    <ul class="like_comment_styles">
                                     <li class="like_comment_only" id="load_comment<?php echo $postCom['comment_id']; ?>">
                                         <?php if (Liked_Comment_Or_Not($this->session->userdata('user_id'),$postCom['comment_id'])): ?>
                                           <span class="unlike fa fa-heart" onclick="return removeReplyLikes('<?php echo $postCom['comment_id']; ?>')"></span>
                                           <span class="like hide fa fa-heart-o" onclick="return addReplyLikes('<?php echo $postCom['comment_id']; ?>')"></span>
                                         <?php else: ?>
                                           <span class="like fa fa-heart-o" onclick="return addReplyLikes('<?php echo $postCom['comment_id']; ?>')"></span>
                                           <span class="unlike hide fa fa-heart" onclick="return removeReplyLikes('<?php echo $postCom['comment_id']; ?>')"></span>
                                         <?php endif; ?>

                                       <span class="likes_count" style="color: #575757;"><?php echo $postCom['like_count']; ?></span>
                                     </li>
                                     <li class="comment_reply_only">
                                       <a href="javascript:void(0);" data-toggle="modal" data-target="#replyModal<?php echo $postCom['comment_id'];?>">
                                        <i class="fas fa-reply"></i>
                                        Reply <span style="color: #575757;"><?php echo $postCom['reply_count']; ?></span>
                                      </a>
                                     </li>
                                     <li>
                                       <a href="javascript:void();" style="font-size: smaller;font-style: oblique;/*! margin-right: -2em; */position: relative;right: -1em;"><?php echo get_time_ago($postCom['commented_at']); ?></a>
                                     </li>
                                   </ul>
                                    <!-- disply replies -->
                                      <?php foreach ($replies as $comReply): ?>
                                        <?php if ($comReply['comment_id'] == $postCom['comment_id']): ?>
                                          <div class="replies" style="margin-top: -1em;">
                                            <div class="pro-names">
                                              <a href="<?php echo base_url(); ?>profile?u=<?php echo $comReply['username']; ?>" class="replied_user_pic mt-2" style="margin-left: 3.1em;">
                                              <?php if (!empty($comReply['profile_pic'])): ?>
                                                <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$comReply['profile_pic']; ?>" width="35" height="35" alt="p.pic">
                                              <?php else: ?>
                                                <img src="<?php echo base_url();?>assets/blank-profile.png" width="35" height="35" alt="p.pic">
                                              <?php endif; ?>
                                            </a>
                                            <a href="<?php echo base_url(); ?>profile?u=<?php echo $comReply['username']; ?>" class="replied_username"><?php echo $comReply['firstname']; ?></a>
                                            </div>
                                            <div class="replies_holder">
                                              <a href="javascript:void(0)" class="a-move-comment pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-h"></i></a>
                                              <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#replyeditModal<?php echo $comReply['reply_id'];?>">
                                                  <i class="fa fa-pencil"></i> Edit reply
                                                </a>
                                                <a class="dropdown-item" href="javascript:void(0)" onclick="deleteReply('<?php echo $comReply['reply_id']; ?>','<?php echo $postCom['comment_id']; ?>')">
                                                  <i class="fa fa-trash" aria-hidden='true'></i> Delete reply
                                                </a>
                                              </div>
                                              <p style="width: 402px;left: 5.6em;"><?php echo getPostLink(nl2br($comReply['reply'])); ?></p>
                                              <span class="pull-right" style="color: #007bff;font-size: smaller;/*! padding-right: -2em; *//*! padding-top: -2em; *//*! margin-left: 5em; */position: relative;top: -2em;left: -4.2em;"><?php echo get_time_ago($comReply['replyed_date']); ?></span>
                                                <!-- visibility spell -->
                                                <!--Edit Post-->
                                              <div class="modal fade" id="replyeditModal<?php echo $comReply['reply_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content">
                                                      <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o"></i> Update reply</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <div class="post-post">
                                                          <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                                                            <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                                                              <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                                                            <?php else: ?>
                                                              <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                                            <?php endif; ?>
                                                          </a>
                                                        </div>
                                                          <textarea name="comment_text" class="textareaClass" id="reply_update_<?php echo $comReply['reply_id']; ?>" placeholder="Write something here..." data-emojiable="true" required><?php echo $comReply['reply'];?></textarea>
                                                         <!--<div class="file-field" style="position: absolute; bottom: .1em; left: 34.5em;">
                                                           <div class="d-flex">
                                                             <div class="after-d-flex">
                                                               <span class="blue-text"><i style="font-size: 2em;" class="fa fa-picture-o"></i></span>
                                                               <input type="file" id="fileUpdate" name="image" onchange="TpValidateupdate('<?php echo $postCom['comment_id'];?>')" accept=".jpg, .png, .gif, .jpeg">
                                                             </div>
                                                           </div>
                                                         </div> -->
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                        <button type="button" id="btnSubmit_<?php echo $comReply['reply_id'] ?>" class="btn btn-primary" onclick="return UpdateReply('<?php echo $comReply['reply_id'] ?>')">Update reply</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <!-- End edit post -->
                                                <!-- visibility spell -->
                                            </div>
                                          </div>
                                        <?php endif ?>
                                      <?php endforeach ?>
                                    <!-- comment reply -->
                                    <div class="modal fade" id="replyModal<?php echo $postCom['comment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o"></i> Reply to this comment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="post-post">
                                                <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                                                  <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                                                    <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                                                  <?php else: ?>
                                                    <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                                  <?php endif; ?>
                                                </a>
                                              </div>
                                                <textarea name="reply_text" class="textareaClass" id="reply_text_<?php echo $postCom['comment_id']?>" placeholder="Write your reply here..." data-emojiable="true" required></textarea>
                                              </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                              <button type="button" id="btnSubmit<?php echo $postCom['comment_id'];?>" class="btn btn-primary" onclick="return reply_on_comment('<?php echo $postCom['comment_id'];?>')">Reply</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <!-- end comment replay -->

                                  <?php if ($this->session->userdata('user_id') == $postCom['user_id']): ?>
                                     <!-- visibility spell -->
                                      <!--Edit Post-->
                                    <div class="modal fade" id="editModal<?php echo $postCom['comment_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o"></i> Update comment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="post-post">
                                                <a href="<?php echo base_url(); ?>profile?u=<?php echo $this->session->userdata('username'); ?>">
                                                  <?php if (!empty($this->session->userdata('profile_pic'))): ?>
                                                    <img src="<?php echo base_url();?><?php echo 'assets/images/profileimages/'.$this->session->userdata('profile_pic'); ?>" width="40" height="40" alt="profile pic">
                                                  <?php else: ?>
                                                    <img src="<?php echo base_url();?>assets/blank-profile.png" width="40" height="40" alt="profile pic">
                                                  <?php endif; ?>
                                                </a>
                                              </div>
                                                <textarea name="comment_text" class="textareaClass" id="comment_update_<?php echo $postCom['comment_id']?>" placeholder="Write something here..." data-emojiable="true" required><?php echo $postCom['comment'];?></textarea>
                                                <input type="hidden" name="commentid" value="<?php echo $postCom['comment_id']; ?>">
                                                <?php if (!empty($postCom['comment_pic']) ): ?>
                                                    <img src="<?php echo base_url();?><?php echo 'assets/images/commentlmages/'.$postCom['comment_pic']; ?>" height="1000" width="1000" style="position: relative; top: .5em; left: 2.7em; width: auto; height: auto; max-height: 140px; max-width: 140px; border-radius: 5px;">
                                                <?php endif; ?>
                                               <!--<div class="file-field" style="position: absolute; bottom: .1em; left: 34.5em;">
                                                 <div class="d-flex">
                                                   <div class="after-d-flex">
                                                     <span class="blue-text"><i style="font-size: 2em;" class="fa fa-picture-o"></i></span>
                                                     <input type="file" id="fileUpdate" name="image" onchange="TpValidateupdate('<?php echo $postCom['comment_id'];?>')" accept=".jpg, .png, .gif, .jpeg">
                                                   </div>
                                                 </div>
                                               </div> -->
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                              <button type="button" id="btnSubmit<?php echo $postCom['comment_id'];?>" class="btn btn-primary" onclick="return UpdateComment('<?php echo $postCom['comment_id'];?>')">Update comment</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- End edit post -->
                                      <!-- visibility spell -->
                                  <?php endif; ?>
                                </div>
                              </div>
                           </div>
                          <?php endif; ?>
                          <!-- end comment area -->
                         <?php endforeach; ?>
                       <!-- </div> -->
                      </div>

                   </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>
    <?php endforeach; ?>
      
<script type="text/javascript">
        // $(document).ready( function(){
        //    $('#test-hello').load('http://localhost/friendmiiDemo/posts');
        //     refresh();
        //   });

        // function refresh()
        // {
        //   setTimeout( function() {
        //     $('#test-hello').fadeOut('slow').load('http://localhost/friendmiiDemo/posts').fadeIn('slow');
        //     refresh();
        //   }, 2000);
        // }

        function editComment(cid){
          $('#commentContent_'+cid).hide();
          $('#editComment_'+cid).show();
        }

        function editComment_cancel(pid){
          $('#commentContent_'+pid).show();
          $('#editComment_'+pid).hide();
        }

        function UpdateComment(cid){
          var comment_text = $.trim($('#comment_update_'+cid).val());
          $("#btnSubmit"+cid).attr("disabled", true);
          if(comment_text == ''){

            }else{
              $.ajax({
                  type:'POST',
                  url:'<?php echo base_url(); ?>posts/UpdateComments/'+cid,
                  data:{"comment_text":comment_text},
                  cache: false,
                  success: function(comment){
                    if (comment == true) {
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

        function UpdateReply(rid){
          var reply_text = $.trim($('#reply_update_'+rid).val());
          $("#btnSubmit_"+rid).attr("disabled", true);
          if(reply_text == ''){

            }else{
              $.ajax({
                  type:'POST',
                  url:'<?php echo base_url(); ?>posts/updatereply/'+rid,
                  data:{"reply_text":reply_text},
                  cache: false,
                  success: function(reply){
                    if (reply == true) {
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

      function reply_on_comment(cid) {
        var reply_text = $.trim($('#reply_text_'+cid).val());
        //alert(reply_text);
         $("#btnSubmit"+cid).attr("disabled", true);
        if(reply_text == ''){

          }else{
            $.ajax({
                type:'POST',
                url:'<?php echo site_url('posts/replyComment/'); ?>'+cid,
                data:{"reply_text":reply_text},
                cache: false,
                success: function(reply){
                  if (reply == true) {
                    setTimeout(function(){
                      location.reload();
                    });
                  }else {
                    alert('Sorry something went wrong, Please try again');
                    return false;
                  }
                },
                error:function() {
                  alert("Sorry something went wrong");
                }
            });
          }
        }

        function savedMy(id){
          $.ajax({
              url: "<?php echo site_url('posts/savePost/'); ?>"+id,
              type: 'post',
              success: function (response){
                  if (response == true){
                      alert("Post was saved successfuly");
                  }else{
                      alert("Failed to save post (post was already saved)!");
                      return false;
                  }
              }
          });
        }

        function removeimage() {
          document.querySelector('#filepreview').setAttribute('src', '');
          var fileInput = document.getElementById('file');
          fileInput.value = '';
          document.querySelector('.emoji-wysiwyg-editor').setAttribute('placeholder','Write something here...');
          document.querySelector('#filepreview').style.display = 'none';
          document.querySelector('#removeimageid').style.display = 'none';
        }


        function triggerClick(e) {
              document.querySelector('#file').click();
          }

      function previewImage(e) {
        if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
          document.querySelector('#filepreview').style.display = 'block';
          document.querySelector('#filepreview').setAttribute('height', 100);
          document.querySelector('#filepreview').setAttribute('width', 100);
          document.querySelector('#filepreview').setAttribute('src', e.target.result);
          document.querySelector('#removeimageid').style.display = 'block';
          document.querySelector('.emoji-wysiwyg-editor').setAttribute('placeholder','Write something about this image...');
        }
        reader.readAsDataURL(e.files[0]);
      }
    }

      function TpValidate(){
        var fileInput = document.getElementById('file');
        var post = document.getElementById('area');
        var postData = post.value;
        var image = fileInput.value;

        if (postData == "" && image == "")
        {
            alert("Please write something...");
            fileInput.value = '';
            post.value = '';
            return false;
        }

        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (image != "") {
          if(!allowedExtensions.exec(image)){
              alert('Please upload file having extensions .jpeg .jpg .png .gif only.');
              fileInput.value = '';
              removeimage();
              return false;
          }
        }

        var fileSize = document.getElementById('file').files[0].size;
        if(fileSize > 2097152){
           alert("Maximum file size exceeded, file size must be less than or equals 2mb");
           fileInput.value = '';
           removeimage();
           return false;
        };

        return true;

    }

    function TpValidateupdate(id){
      var $modal = $("#editModal"+id);
      var postData = $modal.find('#area_update').val();
      var image = $modal.find('#fileUpdate').val();
      var fileSize = $modal.find('#fileUpdate')[0].files[0].size;

      var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      if (image != "") {
        if(!allowedExtensions.exec(image)){
            alert('Please upload file having extensions .jpeg .jpg .png .gif only.');
            fileInput.value = '';
            removeimage();
            return false;
        }
      }

      if(fileSize > 2097152){
         alert("Maximum file size exceeded, file size must be less than or equals 2mb");
         fileInput.value = '';
         removeimage();
         return false;
      };

      return true;

    }

     function validateCommentEdit(id){

      var editedData = document.getElementById('commentEdit');
      var comment = editedData.value;

      if (comment == "") {
        alert("Please write something...");
        editedData.value = '';
        return false;
      }

      return true;
    }

    function validateComment(id){

      var fileInput = document.getElementById('commentfile_'+id);
      var image = fileInput.value;

        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        if (image != "") {
          if(!allowedExtensions.exec(image)){
              alert('Please upload file having extensions .jpeg .jpg .png .gif only.');
              fileInput.value = '';
              removeimage();
              return false;
          }
        }

        var fileSize = document.getElementById('commentfile_'+id).files[0].size;
        if(fileSize > 2097152){
           alert("Maximum file size exceeded, file size must be less than or equals 2mb");
           fileInput.value = '';
           removeimage();
           return false;
        };

        return true;
    }

  // function commentodb(pid){
  //   var comment_text = $.trim($('#comment_text_'+pid).val());
    // var comment_image = $.trim($('#commentfile_'+pid).val());

    // var startIndex = (comment_image.indexOf('\\') >= 0 ? comment_image.lastIndexOf('\\') : comment_image.lastIndexOf('/'));
    // var filename = comment_image.substring(startIndex);
    // if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
    //     filename = filename.substring(1);
    // }

    // if(comment_text == ''){
      //   alert("Please write or upload something to comment.");
      //   return false;
      // }else{
        //    $.ajax({
        //     type:'post',
        //     url: '<?php echo site_url('posts/addComment/'); ?>'+pid,
        //     data:{
        //       "comment_text":comment_text,
        //     },
        //     cache:false,
        //     success: function(comment){
        //       if (comment == true) {
        //          alert("file was uploaded "+pid);
        //       }
        //     }
        // });
     //}
  //}

        function commentodb(pid){
          var comment_text = $.trim($('#comment_text_'+pid).val());
          $("#btnSubmit"+pid).attr("disabled", true);
          if(comment_text == ''){

            }else{
              $.ajax({
                  type:'POST',
                  url:'<?php echo base_url(); ?>posts/addComment/'+pid,
                  data:{"comment_text":comment_text},
                  cache: false,
                  success: function(comment){
                    if (comment == true) {
                      alert('Comment added');
                       $('#comment_text_'+pid).val('');
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

    function addLikes(postid){
      $post = $(this);
      $.ajax({
        url: '<?php echo site_url('posts/addlike'); ?>',
        type: 'post',
         data: {
          'liked' : 1,
          'postid': postid
        },
        success: function(response){
          $post.addClass('hide');
          $post.siblings().removeClass('hide');
          $('#load_post'+postid).load(window.location.href + ' #load_post'+postid);
        },
        error: function() {
          alert("Sorry something went wrong please try again..");
        }
      });
    }


    function removeLikes(postid){
      $post = $(this);
      $.ajax({
        url: '<?php echo site_url('posts/removeLike'); ?>',
        type: 'post',
         data: {
          'unliked' : 1,
          'postid': postid
        },
        success: function(response){
          $post.addClass('hide');
          $post.siblings().removeClass('hide');
          $('#load_post'+postid).load(window.location.href + ' #load_post'+postid);
        },
        error: function() {
          alert("Sorry something went wrong please try again..");
        }
      });
    }

    function addReplyLikes(cid){
      $post = $(this);
      $.ajax({
        url: '<?php echo site_url('posts/addReplylike'); ?>',
        type: 'post',
         data: {
          'liked' : 1,
          'comment_id': cid
        },
        success: function(response){
          $post.addClass('hide');
          $post.siblings().removeClass('hide');
          $('#load_comment'+cid).load(window.location.href + ' #load_comment'+cid);
        },
        error: function() {
          alert("Sorry something went wrong please try again..");
        }
      });
    }


    function removeReplyLikes(cid){
      $post = $(this);
      $.ajax({
        url: '<?php echo site_url('posts/removeReplyLike'); ?>',
        type: 'post',
         data: {
          'unliked' : 1,
          'comment_id': cid
        },
        success: function(response){
          $post.addClass('hide');
          $post.siblings().removeClass('hide');
          $('#load_comment'+cid).load(window.location.href + ' #load_comment'+cid);
        },
        error: function() {
          alert("Sorry something went wrong please try again..");
        }
      });
    }

    function deletePost(post_id){
         if (confirm('Are you sure you want to delete this post?')) {
              $.ajax({
               url: '<?php echo site_url('posts/deletePost/'); ?>'+post_id,
               type: "POST",
                 success: function (response) {
                   alert('Post was deleted');
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

    function deleteReply(rid, cid){
        if (confirm('Are you sure you want to delete this reply?')) {
            $.ajax({
             url: '<?php echo site_url('posts/delete_reply/'); ?>'+rid,
             type: "POST",
             data: {'comment_id': cid},
               success: function (response) {
                 alert('Reply was deleted');
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

    function loadScript() {
       $.ajax({
        method: "GET",
        url: "https://twemoji.maxcdn.com/twemoji.min.js",
        dataType: "script"
      });
    }

    // function deleteComment(comment_id, post_id){
    //   if (confirm('Are you sure you want to delete this comment?')) {
    //     $.ajax({
    //       url: '<?php echo site_url('posts/deleteComment/'); ?>'+comment_id,
    //       type: "POST",
    //       data: {
    //         'postid': post_id,
    //       },
    //       success: function (response) {
    //         //alert('Comment was deleted');
    //         $('#load_comments'+post_id).load(window.location.href + ' #load_comments'+post_id);
    //        },
    //       error: function(){
    //         alert("Sorry something went wrong please try again..");
    //       }
    //     });
    //   }
    // }

    function deleteComment(comment_id, post_id){
         if (confirm('Are you sure you want to delete this comment?')) {
              $.ajax({
               url: '<?php echo site_url('posts/deleteComment/'); ?>'+comment_id,
               type: "POST",
               data: {
                 'postid': post_id,
               },
                 success: function (response) {
                   alert('Comment was deleted');
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

    function showComments(elemid){
      var x = document.getElementById("show_hide_comments_"+elemid);
        if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }
    }

    function activityComments(elemid){
      var x = document.getElementById("show_hide_comments_"+elemid);
        if (x.style.display === "none") {
          x.style.display = "block";
        }
    }


    var textarea = document.querySelector('textarea');
    textarea.addEventListener('keydown', autosize);
    function autosize(){
      var el = this;
      setTimeout(function(){
        el.style.cssText = 'height:auto; padding:0';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
      },0);
    }

    // $(document).ready(function(){
    //   windowOnScroll();
    // });
    //
    // function windowOnScroll() {
    //        $(window).on("scroll", function(e){
    //         if ($(window).scrollTop() == $(document).height() - $(window).height()){
    //             if($(".display_posts_only").length < $("#total_count").val()) {
    //                 var lastId = $(".display_posts_only:last").attr("id");
    //                 getMoreData(lastId);
    //             }
    //         }
    //     });
    // }

    // function getMoreData(lastId) {
    //        $(window).off("scroll");
    //     $.ajax({
    //         url: 'postsForReload(lastId)',
    //         type: "get",
    //         beforeSend: function ()
    //         {
    //             $('.ajax-loader').show();
    //         },
    //         success: function (data) {
    //             setTimeout(function() {
    //                 $('.ajax-loader').hide();
    //           for (var i = 0; i < data.length; i++) {
    //             console.log(data[i]);
    //           }
    //             windowOnScroll();
    //             }, 1000);
    //         }
    //    });
    // }
    // function show_product(){
    //    var id = $(this).attr("data-cid");
    //    var plant = document.getElementById('show_data');
    //    var fruitCount = plant.getAttribute('data-cid');
    //     $.ajax({
    //         type  : 'ajax',
    //         url   : '<?php echo site_url('posts/getallcomments')?>',
    //         async : true,
    //         dataType : 'json',
    //         success : function(data){
    //             var html = '';
    //             var i;
    //             for(i=0; i<data.length; i++){

    //                if (data[i].post_id === fruitCount) {
    //                  html += "<p id='commentContent_"+data[i].comment_id+"'>" +
    //                             data[i].comment +
    //                          "</p>" ;
    //                }
    //                 //console.log(data[i].post_id);
    //             }
    //             //console.log(id + ' ' + fruitCount);

    //             $('#show_data').html(html);
    //         }

    //     });
    // }

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


</script>
     <div class="" style="margin-top:3em;"></div>
  </div>
   