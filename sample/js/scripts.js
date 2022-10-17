const YoutubeRecommendation = {
    listCallbacks: [],
    async loadVideos(url){
        const postData = {
            action: 'youtube_recommendations_videos'
        };
        let request = jQuery.ajax({
            method: 'GET',
            url: url,
            data: postData,
            dataType: 'json'
        })
     return await request.done();
    },

}