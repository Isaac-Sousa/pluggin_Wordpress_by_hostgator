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

    buildList(jsonData, containerId, Layout = 'grid',  limit = 15, lang= "en_US"){
        const myData = jsonData;
        let theList = document.createElement('div');
        theList.className = (Layout == 'list') ? 'yt-rec-list' : 'yt-rec';
        // pode ser também, mas no caso a cima é levado em conta que o layout pode ser grid ou lista
        // theList.className = 'yt-rec';
        let videos = {};
        videos = myData.videos.slice(0, limit)
        for(let i = 0; i < videos.lenght; i++){
            theList.appendChild(
                YoutubeRecommendation.buildListItem(
                    videos[i],
                    myData.channel,
                    lang
                ) //YT-REC-buildlistitem
            )//appendChild
        } //for
        let container = document.querySelector(`#${containerId}`);
        container.innerHTML = '';
        container.appendChild(theList);
    },
    buildListItem(item,channel,Lang){
        const theItem = document.createElement('div');
        theItem.className ='yt-rec-item';
        let viewsText = {
            pt_BR: 'visualizaões',
            en_Us: 'views',
        }

        theItem.innerHTML = `
        <div>
           <a href="${item.link}" target="_blank" title="${item.title}">
           <img class="yt-rec-thumbnail" src="${item.thumbnail}">
           </a>
        </div>
        `;
        return theItem;

    },

}
