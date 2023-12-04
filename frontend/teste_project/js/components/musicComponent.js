
export default function MusicComponent(musicData) {
    const musicComponent = document.createElement('div');
    musicComponent.className = "music_card";

    musicComponent.innerHTML = `
        <div class="music_image_container">
            <img class="music_img artist" src="${musicData.image}" alt=""/>
        </div>
        <div class="music_description">
            <p class="music_title">${musicData.title}</p>
            <p class="music_artist">${musicData.artist}</p>
        </div>
        <div class="icon_container">
            <i class="fa-regular fa-heart"></i>
        </div>
        <div class="play_container">
            <i class="fa-solid fa-circle-play play_icon"></i>
        </div>
    `;

    return musicComponent;
}


