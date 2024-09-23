import React, { useState } from 'react';
import './school.css'; // Using the same styling

function Selfmade() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);

    const projects = [
        {
            title: 'Netflix Homepage clone',
            link: 'https://tgsoftware.services/notflix',
            image: 'https://static.vecteezy.com/system/resources/previews/022/101/069/original/netflix-logo-transparent-free-png.png',
            description: "Remade the Netflix homepage login / register, this was a fun project in the beginning of the first year of college to learn and teach myself how to code.",
            tags: "HTML, CSS",
        },
        {
            title: 'Website Grandpa',
            link: 'https://tgsoftware.services/carpediemchezmargreet',
            image: 'https://scontent-ams4-1.xx.fbcdn.net/v/t39.30808-6/451957143_3799346643638113_5450896627723457261_n.jpg?stp=cp6_dst-jpg&_nc_cat=103&ccb=1-7&_nc_sid=833d8c&_nc_ohc=SkkZi7CcskIQ7kNvgH89QlZ&_nc_ht=scontent-ams4-1.xx&oh=00_AYCGOPVJh17dzXlgBGb7tIQO1UUSbo9j5YhR3OVL4VH4CQ&oe=66F79D46',
            description: "This website i made for my grandma and grandpa to improve my skills and get them a nice looking basic website for all their endevours.",
            tags: "HTML, CSS, JS",
        },
        {
            title: 'Simple Geometry Dash',
            link: 'https://tgsoftware.services/game',
            image: 'https://www1.minijuegosgratis.com/v3/games/thumbnails/213070_1.jpg',
            description: "This is a geometry dash game but then the really basic version of it. It keeps the score but does not have a menu or anything. Build this mainly for Javascript improvement.",
            tags: "HTML, CSS, JS",
        },
        {
            title: 'FlavorFlow.',
            description: 'Unfinished project that replaces thuisbezorgd. php/css/js',
            link: 'https://tgsoftware.services/flavorflow',
            image: 'https://cdn.pixabay.com/photo/2016/05/31/10/52/not-yet-1426593_640.png',
            description: "This is a big project i started working on in 2023. This project was for learning more about php and javascript combined to create a seamless shopping experience. This project is still not finished due to lack of motivation. This project is using the google maps api and some other cool features. IMPORTANT! use zipcode of Medemblik the netherlands and a random street number. It's location is verified through maps.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Storm Services',
            description: 'Website for client, first php. php/css/js',
            link: 'https://tgsoftware.services/storm',
            image: 'https://i.ytimg.com/vi/asTesU-2t3k/maxresdefault.jpg',
            description: "This was my first actual website for a client named Storm, this was also my first ever php based website.",
            tags: "PHP, HTML, CSS, JS",
        },
    ];

    const openPopup = (project) => {
        setSelectedProject(project);
        setPopupVisible(true);
    };

    const closePopup = () => {
        setPopupVisible(false);
        setSelectedProject(null);
    };

    return (
        <section className="school">
            {projects.map((project, index) => (
                <div
                    key={index}
                    className="school__card"
                    style={{ animationDelay: `${index * 0.1}s` }} // Dynamic animation delay
                >
                    <div className='school__cardimgcontainer'>
                        <img className="school__cardImage" src={project.image} alt={`Project ${index + 1}`} />
                    </div>
                    <div className="school__cardContent">
                        <h2 className="school__cardTitle">{project.title}</h2>
                        <p className="school__cardTags">tags: {project.tags}</p>
                        <button className="school__cardButton" onClick={() => openPopup(project)}>
                            Learn more
                        </button>
                    </div>
                </div>
            ))}

            {popupVisible && selectedProject && (
                <div className="popup">
                    <div className="popupContainer grower2"> 
                        <div className="selectedImgContainer trans2">
                            <img className="popup__cardImage" src={selectedProject.image} alt={`Project ${selectedProject.index + 1}`} /> 
                        </div>
                        <div className="popup__content trans2">
                            <div className="textContainer">
                                <h2>{selectedProject.title}</h2>
                                <p>{selectedProject.description}</p>
                            </div>
                            <p className="school__cardTags">tags: <b>{selectedProject.tags}</b></p>
                            <div className="buttonscontainer">
                                <a className="school__cardButton" href={selectedProject.link} target="_blank" rel="noopener noreferrer">
                                    Go to Project
                                </a>
                                <button className="school__cardButton" onClick={closePopup}>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </section>
    );
}

export default Selfmade;
