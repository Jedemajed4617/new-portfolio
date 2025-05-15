import React, { useState, useEffect, useRef } from 'react';
import './skills.css';

const javascript = '/img/JS.webp';
const python = '/img/Python.webp';
const php = '/img/Php.webp';
const css = '/img/css.webp';
const html = '/img/html.webp';
const react = '/img/react.webp';
const ci4 = 'https://cdn.iconscout.com/icon/free/png-256/free-codeigniter-logo-icon-download-in-svg-png-gif-file-formats--wordmark-programming-langugae-language-pack-logos-icons-1175201.png?f=webp&w=256';
const git = 'https://cdn-icons-png.flaticon.com/512/25/25231.png';
const sql = 'https://www.svgrepo.com/show/303251/mysql-logo.svg';
const laravel = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png';


function Skills() {
    const currentYear = new Date().getFullYear();
    const [allSkillsVisible, setAllSkillsVisible] = useState(false);
    const [tooltipVisible, setTooltipVisible] = useState(true);
    const [titleVisible, setTitleVisible] = useState(false);
    const skillsContainerRef = useRef(null);

    const skills = [
        { title: 'Javascript', since: 2021, image: javascript },
        { title: 'Python', since: 2022, image: python },
        { title: 'PHP', since: 2021, image: php },
        { title: 'Laravel', since: 2023, image: laravel },
        { title: 'React', since: 2022, image: react },
        { title: 'CSS', since: 2020, image: css },
        { title: 'HTML', since: 2020, image: html },
        { title: 'SQL', since: 2022, image: sql },
        { title: 'GIT', since: 2021, image: git },
        { title: 'CI4', since: 2023, image: ci4 },
        { title: 'Wordpress', since: 2023, image: 'https://upload.wikimedia.org/wikipedia/commons/9/98/WordPress_blue_logo.svg' },
        { title: 'Adobe XD', since: 2021, image: 'https://upload.wikimedia.org/wikipedia/commons/c/c2/Adobe_XD_CC_icon.svg' }
    ];

    const getExperienceString = (since) => {
        const years = currentYear - since + 1;
        return `${years}+ year${years > 1 ? 's' : ''} of experience`;
    };

    useEffect(() => {
        const skillsElements = skillsContainerRef.current?.querySelectorAll('.skills__content');
        const animationDuration = 400; 
        const staggerDelay = 100;

        if (skillsElements && allSkillsVisible) {
            const lastIndex = skillsElements.length - 1;
            skillsElements.forEach((skill, index) => {
                setTimeout(() => {
                    skill.classList.add('active');
                    if (index === lastIndex) {
                        setTimeout(() => {
                            setTitleVisible(true);
                        }, animationDuration); // Show title after the last card's animation
                    }
                }, staggerDelay * index);
            });
        } else if (skillsElements && !allSkillsVisible) {
            const firstSkill = skillsElements[0];
            if (firstSkill) {
                setTimeout(() => {
                    firstSkill.classList.add('active');
                }, 300);
            }
            setTitleVisible(false); 
        }

        return () => {
            skillsElements?.forEach(skill => {
                skill.classList.remove('active');
            });
            setTitleVisible(false);
        };
    }, [allSkillsVisible]);


    const handleFirstSkillClick = () => {
        setAllSkillsVisible(true);
        setTooltipVisible(false);
    };

    return (
        <section className="skills">
            <div className="skills__container" ref={skillsContainerRef}>
                <ul className="skills__container">
                    {skills.map((skill, index) => (
                        <li
                            key={index}
                            className="skills__content"
                            onClick={index === 0 && !allSkillsVisible ? handleFirstSkillClick : undefined}
                            onMouseEnter={() => { if (index === 0 && !allSkillsVisible) setTooltipVisible(true); }}
                            onMouseLeave={() => setTooltipVisible(false)}
                        >
                            <div className="skills__contentImgContainer">
                                <img className="skills__contentIMG" src={skill.image} alt={`Not loading skill img ${index + 1}`} />
                            </div>
                            <div className="skills__contentTextArea">
                                <h1 className="skills__contentTitle">{skill.title}</h1>
                                <p className="skills__contentInfo">{getExperienceString(skill.since)}</p>
                            </div>
                            {index === 0 && tooltipVisible && !allSkillsVisible && (
                                <div className="skill-tooltip">Click to expand</div>
                            )}
                        </li>
                    ))}
                </ul>
                {titleVisible && <h2 className={`skills__main-title ${titleVisible ? 'visible' : ''}`}>Mijn skills</h2>}
            </div>
        </section>
    );
}

export default Skills;