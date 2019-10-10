// $(document).ready(function(){
//   $(function).on('click', '.like-btn', function(){
//     var post_id = $(this).data('post');
//     var user_id = $(this).data('user');
//     var counter = $(this).find('.likesCounter');
//     var count   = counter.text()
//     var button  = $(this);
//
//     $.post('http://localhost/testproject/posts/like', {like:post_id, user_id:user_id}, function(){
//       button.addClass('unlike-btn');
//       button.removeClass('like-btn');
//       count++;
//       counter.text(count);
//       button.find('.fa-heart-o').addClass('fa-heart');
//       button.find('.fa-heart').removeClass('fa-heart-o');
//
//     });
//
//   });
// });
