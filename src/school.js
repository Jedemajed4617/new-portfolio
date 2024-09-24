import React, { useState } from 'react';
import './school.css'; 

function School() {
    const [popupVisible, setPopupVisible] = useState(false);
    const [selectedProject, setSelectedProject] = useState(null);

    const projects = [
        {
            title: 'Spatify (spotify clone)',
            link: 'https://tgsoftware.services/spatify',
            image: 'https://play-lh.googleusercontent.com/cShys-AmJ93dB0SV8kE6Fl5eSaf4-qMMZdwEDKI5VEmKAXfzOqbiaeAsqqrEBCTdIEs=w240-h480-rw',
            description: "This is a website a made for a school assignment. This website has it's own small library of songs that you can acces. This was to train my php skills in sorting, searching and adding songs with a small custom csm system.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Daily Paper Clone',
            link: 'https://tgsoftware.services/dailypaper',
            image: 'https://www.asphaltgold.com/cdn/shop/files/ca802008830dc007677dcccde8cf41e179b52d66_2322035_Daily_Paper_Ezar_Zip_Hoodie_Black_os_3_768x768.jpg?v=1700042914',
            description: "This was an assignment for school I made with php, This is a full scale daily paper clone with working cms, login, dipuste system, review system and much more. Had so much fun creating this prject because it enhanced my capability to write php.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Tulpreizen',
            link: 'https://tgsoftware.services/tulpreizen',
            image: 'https://www.whiteflowerfarm.com/mas_assets/cache/image/9/4/e/b/38123.Jpg',
            description: "This was a small website for school that shows of a bit of scss skills i used for it. Nothing much to it other then nice!",
            tags: "HTML, SCSS, CSS",
        },
        {
            title: 'Font Showcase',
            link: 'https://tgsoftware.services/font-showcase',
            image: 'https://img.freepik.com/free-vector/creative-halloween-alphabet-design_23-2147932875.jpg?size=338&ext=jpg&ga=GA1.1.1413502914.1696809600&semt=ais',
            description: "This was a website created for previewing different font styles with js. Anything you type into the bar will show it in the font listed.",
            tags: "HTML, CSS, JS",
        },
        {
            title: 'NVVN Website',
            link: 'https://tgsoftware.services/nvvn',
            image: 'https://nvvn.nl/wp-content/uploads/2021/06/NVVN-favicon.png',
            description: "This is a website made for the official NVVN. We needed to show what we had learned the previous years and just make a website for them.",
            tags: "PHP, HTML, CSS, JS",
        },
        {
            title: 'Qr Code',
            link: 'https://tgsoftware.services/qrcode',
            image: 'https://media.istockphoto.com/id/1347277567/vector/qr-code-sample-for-smartphone-scanning-on-white-background.jpg?s=612x612&w=0&k=20&c=PYhWHZ7bMECGZ1fZzi_-is0rp4ZQ7abxbdH_fm8SP7Q=',
            description: "This was a really fun project. This website i made could generate qr codes after you had taken a picture with any device on the website and the if you had scan the QR-code you were redirected to a different page to collect your photo.",
            tags: "PHP, HMTL, CSS, JS",
        },
        {
            title: 'Rabbit (Reddit clone)',
            link: 'https://tgsoftware.services/socialmedia',
            image: 'https://styles.redditmedia.com/t5_5s5qbl/styles/communityIcon_tqrzte0yaa3c1.png',
            description: "This was a small assignment for school creating the infinite scroller like instagram, reddit or twitter. The content is drawn from an api and loaded in infinitely.",
            tags: "HTML, CSS, JS",
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

export default School;