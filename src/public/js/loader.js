(function($){
   $(function(){
       YoutubeRecommendation.loadVideos(yt_rec_ajax.url). then((value) => {
           YoutubeRecommendation.listCallbacks.forEach((item) => {
               item.callback(value, item.containerId, item.layout, item.limit, item.lang);
           })
       });


   });
})(jQuery);




