import React from 'react';
import './skills.css'; // Make sure to import your CSS file

const javascript = '/img/JS.webp';   
const python = '/img/Python.webp';   
const php = '/img/Php.webp';           
const css = '/img/css.webp';  
const html = '/img/html.webp';
const react = '/img/react.webp';

function Skills() {
    return (
        <section className="skills">
            <ul className="skills__container">
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={javascript} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">JavaScript</h1>
                        <p className="skills__contentInfo">3+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={python} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">Python</h1>
                        <p className="skills__contentInfo">3+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={php} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">PHP</h1>
                        <p className="skills__contentInfo">2+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png" alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">Laravel</h1>
                        <p className="skills__contentInfo">1+ years of experience</p>
                    </div>
                </li>
            </ul>
            <ul className="skills__container">
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={css} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">CSS</h1>
                        <p className="skills__contentInfo">3+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={react} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">React</h1>
                        <p className="skills__contentInfo">2+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src={html} alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">HTML</h1>
                        <p className="skills__contentInfo">3+ years of experience</p>
                    </div>
                </li>
                <li className="skills__content skills__content--flipped">
                    <div className="skills__contentImgContainer">
                        <img className="skills__contentIMG" src="https://www.svgrepo.com/show/303251/mysql-logo.svg" alt="" />
                    </div>
                    <div className="skills__contentTextArea">
                        <h1 className="skills__contentTitle">SQL</h1>
                        <p className="skills__contentInfo">2+ years of experience</p>
                    </div>
                </li>
            </ul>
        </section>
    );
}

export default Skills;