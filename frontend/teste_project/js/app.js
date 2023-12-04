
import CardContainer from './components/cardContainer.js';

document.addEventListener('DOMContentLoaded', function () {
    const appContainer = document.getElementById('app');

    const sampleMusicData = [
        { title: 'Good Time', artist: 'Jack Olive', image: "https://images.unsplash.com/photo-1511379938547-c1f69419868d?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" },
        { title: 'Livin’ Life', artist: 'Marcus Autumn', image: 'https://images.unsplash.com/photo-1471523835123-1172efe5eaa1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
        { title: 'Other Worlds', artist: 'The Outsiders', image: 'https://images.unsplash.com/photo-1560785218-b81145a78602?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
        { title: 'Walking by you', artist: 'Life Monkeys', image: 'https://images.unsplash.com/photo-1552599886-a5dd807f93be?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
        { title: 'Automatic Stop', artist: 'The Strokes', image: 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
        
    ]; 
             
    const iconMusic = '<i class="fa-solid fa-music"></i>'
    const iconAlbum = '<i class="fa-solid fa-compact-disc"></i>'

    const container = CardContainer('Music', sampleMusicData, iconMusic,'musics');
    const container2 = CardContainer('Albums', sampleMusicData, iconAlbum,'albums');
    const container3 = CardContainer('Artists', sampleMusicData, iconAlbum,'artists');
    const container4 = CardContainer('Playlists', sampleMusicData, iconAlbum,'playlists');
    appContainer.appendChild(container);
    appContainer.appendChild(container2);
    appContainer.appendChild(container3);
    appContainer.appendChild(container4);
});


