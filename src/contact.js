import "./contact.css";
import React from 'react';

function Contact() {
    const contacts = [
        {
            title: 'Adres:',
            subtitle: 'Koningshof 25, 1671AM te Medemblik',
            link: 'https://www.google.com/maps/place/Koningshof+25,+1671+AM+Medemblik/@52.7733593,5.1066674,17z/data=!3m1!4b1!4m6!3m5!1s0x47c8b02e769dd293:0xeba2b50848fa3b48!8m2!3d52.7733561!4d5.1092423!16s%2Fg%2F11c19d4cs3?entry=ttu&g_ep=EgoyMDI0MDkxMC4wIKXMDSoASAFQAw%3D%3D'
        },
        {
            title: 'KVK:',
            subtitle: '93297173',
            link: 'https://www.kvk.nl/bestellen/#/93297173000058852964'
        },
        {
            title: 'Telefoon:',
            subtitle: '+31 6 28856671',
            link: 'tel:+31628856671'
        },
        {
            title: 'Email:',
            subtitle: 'tygoiedema@gmail.com',
            link: 'mailto:tygoiedema@gmail.com'
        },
        {
            title: 'Social:',
            subtitle: 'LinkedIn',
            link: 'https://www.linkedin.com/in/tygo-jedema-579458250/'
        },
    ];
    
    return (
        <div className="contact">
            <div className="contact-container">
                <div className="contact-info">
                    {contacts.map((contact, index) => (
                        <div key={index}>
                            <span>{contact.title}</span>
                            <a target="_blank" rel="noopener noreferrer" href={contact.link}>{contact.subtitle}</a>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
}

export default Contact;