 import React from 'react';
import './school.css'; // Make sure to import your CSS file

function School() {
    const projects = [
        {
            title: 'Spatify',
            description: 'Spotify website clone, php/css/js/sql',
            link: 'https://tgsoftware.services/spatify',
            image: 'https://play-lh.googleusercontent.com/cShys-AmJ93dB0SV8kE6Fl5eSaf4-qMMZdwEDKI5VEmKAXfzOqbiaeAsqqrEBCTdIEs=w240-h480-rw',
        },
        {
            title: 'Daily Paper Clone',
            description: 'Daily paper website clone, php/css/js/sql',
            link: 'https://tgsoftware.services/dailypaper',
            image: 'https://www.asphaltgold.com/cdn/shop/files/ca802008830dc007677dcccde8cf41e179b52d66_2322035_Daily_Paper_Ezar_Zip_Hoodie_Black_os_3_768x768.jpg?v=1700042914',
        },
        {
            title: 'Tulpreizen',
            description: 'Tulip Travel website, html/css',
            link: 'https://tgsoftware.services/tulpreizen',
            image: 'https://www.whiteflowerfarm.com/mas_assets/cache/image/9/4/e/b/38123.Jpg',
        },
        {
            title: 'Font Showcase',
            description: 'Font showcase website, html/css/js',
            link: 'https://tgsoftware.services/font-showcase',
            image: 'https://img.freepik.com/free-vector/creative-halloween-alphabet-design_23-2147932875.jpg?size=338&ext=jpg&ga=GA1.1.1413502914.1696809600&semt=ais',
        },
        {
            title: 'NVVN Website assignment',
            description: 'Website for a client with php, php/css/js/sql',
            link: 'https://tgsoftware.services/nvvn',
            image: 'https://nvvn.nl/wp-content/uploads/2021/06/NVVN-favicon.png',
        },
        {
            title: 'Qr Code',
            description: 'Website for an assignment for school. simple styling, advanced backend, php/css/js/sql',
            link: 'https://tgsoftware.services/qrcode',
            image: 'https://media.istockphoto.com/id/1347277567/vector/qr-code-sample-for-smartphone-scanning-on-white-background.jpg?s=612x612&w=0&k=20&c=PYhWHZ7bMECGZ1fZzi_-is0rp4ZQ7abxbdH_fm8SP7Q=',
        },
        {
            title: 'Rabbit (infinite scroller)',
            description: 'Website for an assignment for school in the style of reddit and instagram mixed, html/css/js',
            link: 'https://tgsoftware.services/socialmedia',
            image: 'https://styles.redditmedia.com/t5_5s5qbl/styles/communityIcon_tqrzte0yaa3c1.png',
        },
        
    ];

    return (
        <section className="school">
            {projects.map((project, index) => (
                <div key={index} className="school__card">
                    <div className='school__cardimgcontainer'>
                        <img className="school__cardImage" src={project.image} alt={`Project ${index + 1}`} />
                    </div>
                    <div className="school__cardContent">
                        <h2 className="school__cardTitle">{project.title}</h2>
                        <p className="school__cardDescription">{project.description}</p>
                        <a className="school__cardButton" href={project.link} target="_blank" rel="noopener noreferrer">
                            View Project
                        </a>
                    </div>
                </div>
            ))}
        </section>
    );
}

export default School;