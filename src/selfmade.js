import React from 'react';
import './school.css'; // Using the same styling

function Selfmade() {
    const projects = [
        {
            title: 'Advertising website',
            description: 'Discontinued idea of making a advertising business website, html/css/js',
            link: 'https://tygojedema.xyz/mb-media',
            image: '../img/photo1.webp',
        },
        {
            title: 'Telegram Advert BOT',
            description: 'Discontinued idea of making a telegram bot advertising in servers, html/css/js',
            link: 'https://tygojedema.xyz/prime',
            image: 'https://store-images.s-microsoft.com/image/apps.55245.13537716651231321.3067a421-6c2f-48a9-b77c-1e38e19146e6.10e2aa49-52ca-4e79-9a61-b6422978afb9',
        },
        {
            title: 'Storm Spoofer',
            description: 'First website built for a client, not functional anymore, php/css/js',
            link: 'https://tygojedema.xyz/storm',
            image: '../img/StormBox.webp',
        },
        {
            title: 'Netflix Homepage clone',
            description: 'First ever website made for improving my skills, html/css',
            link: 'https://tygojedema.xyz/notflix',
            image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png',
        },
        {
            title: 'Business website Grandma/Grandpa',
            description: 'Website made for my grandpa and grandma, html/css/js',
            link: 'https://tygojedema.xyz/carpediemchezmargreet',
            image: 'https://tygojedema.xyz/carpediemchezmargreet/img/about.webp',
        },
        {
            title: 'Lucky Spoofer',
            description: 'Website for another client, html/css/js',
            link: 'https://tygojedema.xyz/luckyspoofer',
            image: 'https://luckysp00fer.xyz/photo/TEST.png',
        },
        {
            title: 'Emirates NBD clone',
            description: 'Website made for improving my coding skills, html/css',
            link: 'https://tygojedema.xyz/nbd',
            image: 'https://pbs.twimg.com/profile_images/1050366049688928256/SBzdN7Dh_400x400.jpg',
        },
        {
            title: 'FlavorFlow',
            description: 'Unfinished project that replaces thuisbezorgd. Working on it. php/css/js',
            link: 'https://tygojedema.xyz/flavorflow',
            image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png',
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

export default Selfmade;