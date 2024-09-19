import React from 'react';
import './skills.css'; // Make sure to import your CSS file

const javascript = '/img/JS.webp';   
const python = '/img/Python.webp';   
const php = '/img/Php.webp';           
const css = '/img/css.webp';  
const html = '/img/html.webp';
const react = '/img/react.webp';
const sql = 'https://www.svgrepo.com/show/303251/mysql-logo.svg';
const laravel = 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png';

function Skills() {
    const skills = [
        {
            title: 'Javascript',
            experience: '3+ years of experience',
            image: javascript
        },
        {
            title: 'Python',
            experience: '2+ years of experience',
            image: python
        },
        {
            title: 'PHP',
            experience: '3+ years of experience',
            image: php
        },
        {
            title: 'Laravel',
            experience: '1+ years of experience',
            image: laravel
        },
        {
            title: 'React',
            experience: '2+ years of experience',
            image: react
        },
        {
            title: 'CSS',
            experience: '4+ years of experience',
            image: css
        },
        {
            title: 'HTML',
            experience: '4+ years of experience',
            image: html
        },
        {
            title: 'SQL',
            experience: '2+ years of experience',
            image: sql
        },
    ]; 

    return (
        <section className="skills">
            <ul className="skills__container">
                {skills.map((skill, index) => (
                    <li key={index} className="skills__content">
                        <div className="skills__contentImgContainer">
                            <img className="skills__contentIMG" src={skill.image} alt={`Not loading skill img ${index + 1}`} />
                        </div>
                        <div className="skills__contentTextArea">
                            <h1 className="skills__contentTitle">{skill.title}</h1>
                            <p className="skills__contentInfo">{skill.experience}</p>
                        </div>
                    </li>
                ))}
            </ul>
        </section>
    );
}

export default Skills;