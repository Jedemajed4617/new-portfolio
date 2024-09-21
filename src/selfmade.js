import React from 'react';
import './school.css'; // Using the same styling

function Selfmade() {
    const projects = [
        {
            title: 'Netflix Homepage clone',
            description: 'First ever website made for improving my skills, html/css',
            link: 'https://tgsoftware.services/notflix',
            image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png',
        },
        {
            title: 'Business website Grandma/Grandpa',
            description: 'Website made for my grandpa and grandma, html/css/js',
            link: 'https://tgsoftware.services/carpediemchezmargreet',
            image: 'https://tgsoftware.services/carpediemchezmargreet/img/about.webp',
        },
        {
            title: 'Simple Geometry Dash',
            description: 'Website made for improving my coding skills, html/css/js',
            link: 'https://tgsoftware.services/game',
            image: 'https://i.pinimg.com/originals/9b/37/18/9b3718113bf81ce525f410a50e847782.png',
        },
        {
            title: 'FlavorFlow',
            description: 'Unfinished project that replaces thuisbezorgd. php/css/js',
            link: 'https://tgsoftware.services/flavorflow',
            image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png',
        },
        {
            title: 'Storm Services',
            description: 'Website for client, first php. php/css/js',
            link: 'https://tgsoftware.services/storm',
            image: 'https://yt3.googleusercontent.com/NkPjOVCsOqSUA4Cyd1ET585ENqFbDHOCOy1jVLnD8J5nDiLqNNUxSQhKb1c9CoTW4Rv8uwQu=s160-c-k-c0x00ffffff-no-rj',
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