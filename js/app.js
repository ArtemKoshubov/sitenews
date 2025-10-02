let page = 1;
let pagstart = 1;
let allpages = 1;
$(document).ready(function(){
    LoadNewsAtPages(page);
});
function LoadNewsAtPages(page){
    $.ajax({
        url:"getnewspages.php",
        type:"POST",
        contentType:"application/json",
        data:JSON.stringify(
            {
                page:page
            }
        ),
        success:function(response){
            if(response.success){
                LoadPage(response.news);
                allpages = response.pages;
                LoadPag();
            }
            else{
                console.log(response.news);
            }
        },
        error:function(response){
            console.log(response.responseText);
        }
    });
}
function LoadPage(news){
    let pageBlock = $(".newsblock");
    pageBlock.empty();
    news.forEach(element => {
    const newDate = formatDate(element.date)
    let html = `
        <div class="new">
            <p class="date">${newDate}</p>
            <h1 class="titlenew">${element.title}</h1>
            <p class="brief">${element.announce}</p>
            <button class="details" data-id = '${element.id}'>Подробнее</button>
        </div>
        `;
    pageBlock.append(html);
    });
}
function formatDate(datestr){
    const date = new Date(datestr);
    const day = String(date.getDate()).padStart(2,'0');
    const mounth = String(date.getMonth() + 1).padStart(2,'0');
    const year = date.getFullYear();
    return day + "." + mounth + "."+year;
}
function LoadPag(keep = false){
    if(!keep){
        pagstart = Math.floor((page-1)/3)*3 + 1;
    }
    const pagestop = Math.min(pagstart+2,allpages);
    $(".count").each(function(index){
        const pageNum = pagstart + index;
        if(pageNum<=pagestop){
            $(this).find("p").text(pageNum);
            $(this).attr("data-page",pageNum);
            $(this).show();
            if(pageNum === page){
                $(this).addClass("active");
                $(this).css("background-color","#841844");
                $(this).css("color","white");
            }else{
                $(this).removeClass("active");
                $(this).css("background-color","white");
                $(this).css("color","#841844");
            }
        }else{
            $(this).hide();
        }
    });
    if(pagestop >=allpages){
        $(".next").hide();
    }else{
        $(".next").show();
    }
}
$(document).on("click", ".count",function(){
    page = $(this).attr("data-page");
    page = parseInt(page);
    LoadNewsAtPages(page);
});
$(document).on("click", ".next",function(){
    pagstart += 3;
    LoadPag(true);
});
$(document).on("click",".details", function(){
    const id = $(this).data("id");
    window.location.href = "./details.php?id="+id;
});