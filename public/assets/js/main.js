$(document).ready(function(){
    // toggle navigation
    $('#nav-toggle').click(function(){
        $('.header .nav').slideToggle();
    })

    // fixed header
    $(window).scroll(function(){
        if($(this).scrollTop() > 100){
            $('.header').addClass('fixed')
            $('.scroll-to-header').removeClass('none')
        }
        else{
            $('.header').removeClass('fixed')
            $('.scroll-to-header').addClass('none')
        }
        
    })

    $('.header .nav a').click(function(){
        if($(window).width() < 768){
            $('.header .nav').slideToggle();
        }
    })


    $('a').on('click', function(event){
        if (this.hash !== ""){
            event.preventDefault();

            // store hash
            var hash = this.hash;

            // using jquery to animate the scroll smooth
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
                window.location.hash = hash
            })
        }
    })


    // show categories
    $('#category-list').on('click', function(){
        $('#categories').slideToggle()
    })

    // new Comment btn

    $('#sendComment').on('click', function(event){
        event.preventDefault();
        $('#newComment').html('');
    })
})

function cancelComment(){
    $('#newComment').html('')
}

function newComment(route, productId, parent_id = null){
    let csrf = document.head.querySelector('meta[name="csrf-token"]').content;

    console.log(csrf)

    let htmlTemplate = 
    `
    <div class="new-comment-form">
        <div class="ncf-header">
            <h1>نظر جدید</h1>
        </div>
        <div class="ncf-body">
            <form action="${route}" method="post">
                ${
                    parent_id != null ? `<input type="hidden" value="${parent_id}" name="parent_id">` : ``
                }
                <input type="hidden" name="_token" value="${csrf}">
                <input type="hidden" value="${productId}" name="product_id">
                <textarea class="newComment-area" name="comment" cols="30" rows="10" placeholder="نظر شما"></textarea>
                <button class="new-comment" type="submit" id="sendComment">ثبت نظر</button>
                <button class="cancel-comment" type="button" onclick="cancelComment()">لفو</button>
            </form>
        </div>
    </div>
    `;
    $('#newComment').html(htmlTemplate);
}