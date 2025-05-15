import "./cv.css";
import React from 'react';

function Contact() {
    const jobs = [
        {
            jobtitle: 'Leerling-kok Rumours Medemblik',
            desc: 'Leerling-kok bij Rumours.',
            date: '2020 - 2022',
            link: 'https://www.eetcaferumours.nl/',
        },
        {
            jobtitle: 'Picnic Bezorger',
            desc: 'Bezorger bij Picnic.',
            date: '2022 - 2023',
            link: 'https://www.picnic.nl/',
        },
        {
            jobtitle: 'DHL Bezorger',
            desc: 'Bezorger bij DHL.',
            date: '2023 - 2025',
            link: 'https://www.dhl.com/',
        },
        {
            jobtitle: 'Stagair Velisoft B.V.',
            desc: 'Stage bij Velisoft B.V. als software ontwikkelaar.',
            date: '2025 - heden',
            link: 'https://www.velisoft.nl/',
        },
        {
            jobtitle: 'Albert Heijn Bezorger',
            desc: 'Bezorger bij Albert Heijn.',
            date: '2025 - heden',
            link: 'https://www.ah.nl/',
        },
    ];

    return (
        <div className="cv">
            <div className="cv__sidebar">
                <img src="/img/me2.jpg" alt="Tygo Jedema" className="cv__image" />
                <h1 className="cv__name">Tygo Jedema</h1>
                <p className="cv__role">Software ontwikkelaar</p>
                <div className="cv__skills">
                    <h3 className="cv__skills-title">Skills</h3>
                    {[
                        { name: "HTML", level: 5 },
                        { name: "CSS", level: 5 },
                        { name: "JavaScript", level: 4 },
                        { name: "React", level: 4 },
                        { name: "PHP", level: 3 },
                        { name: "SQL", level: 3 },
                        { name: "Git", level: 4 },
                    ].map((skill, index) => (
                        <div className="cv__skill" key={index}>
                        <span className="cv__skill-name">{skill.name}</span>
                        <div className="cv__skill-bar">
                            {[1, 2, 3, 4, 5].map((n) => (
                            <div
                                key={n}
                                className={`cv__skill-diamond ${n <= skill.level ? "filled" : ""}`}
                            />
                            ))}
                        </div>
                        </div>
                    ))}
                </div>
            </div>
            <div className="cv__content">
                <h2 className="cv__section-title">Werkervaring</h2>
                <div className="cv__timeline">
                    {jobs.map((job, index) => (
                        <div
                            className="cv__item"
                            key={index}
                            style={{ animationDelay: `${index * 0.2}s` }}
                        >
                            <div className="cv__job-title">{job.jobtitle}</div>
                            <div className="cv__date">{job.date}</div>
                            <a
                                className="cv__desc"
                                target="_blank"
                                rel="noopener noreferrer"
                                href={job.link}
                            >
                                {job.desc || 'Meer informatie'}
                            </a>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}

export default Contact;
