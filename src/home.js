import React, { useState, useEffect, useMemo } from 'react';
import './home.css';

function Home() {
    const [animationComplete, setAnimationComplete] = useState(false);
    const [displayText, setDisplayText] = useState('Fullstack Developer');
    const words = useMemo(() => ['Fullstack Developer', 'Web Developer', 'Back-end Developer'], []); // Memoize words
    const [index, setIndex] = useState(0);
    const [isDeleting, setIsDeleting] = useState(false);
    const [showCursor, setShowCursor] = useState(true);

    useEffect(() => {
        const grower = document.querySelector('.grower');
        grower.addEventListener('animationend', () => {
            setAnimationComplete(true);
        });

        return () => grower.removeEventListener('animationend', () => {
            setAnimationComplete(true);
        });
    }, []);

    useEffect(() => {
        if (animationComplete) {
            const interval = setInterval(() => {
                setDisplayText(prev => {
                    if (!isDeleting) {
                        return prev.substring(0, prev.length - 1);
                    } else {
                        const nextWord = words[(index + 1) % words.length];
                        if (prev.length < nextWord.length) {
                            return nextWord.substring(0, prev.length + 1);
                        } else {
                            setIndex((index + 1) % words.length);
                            setIsDeleting(false);
                            return nextWord;
                        }
                    }
                });

                if (displayText === '') {
                    setIsDeleting(true);
                } else if (isDeleting && displayText === words[index]) {
                    setIsDeleting(false);
                }
            }, isDeleting ? 75 : 150);

            return () => clearInterval(interval);
        }
    }, [animationComplete, displayText, index, isDeleting, words]);

    useEffect(() => {
        const cursorInterval = setInterval(() => {
            setShowCursor(prev => !prev);
        }, 500);

        return () => clearInterval(cursorInterval);
    }, []);

    return (
        <section className="homeContent" style={{ backgroundColor: '#1E1E1E' }}>
            <div className="container">
                <div className="grower">
                    {animationComplete && (
                        <div id="nameText" className="trans">
                            <h1 className="eerste">My name is,</h1>
                            <div className="tranq">
                                <h1 className="tweede">Tygo Jedema</h1>
                                <h1 className="derde">I am a </h1>
                            </div>
                            <h1 className="vierde">
                                {displayText}
                                {showCursor && <span className="cursor-line"></span>} {/* Line instead of cursor */}
                            </h1>
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}

export default Home;
 