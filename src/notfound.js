import React from 'react';

const NotFound = () => {
  return (
    <div className="not-found-container">
      <style>
        {`
          .not-found-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #1e1e1e;
            color: #fff;
            font-family: sans-serif;
            text-align: center;
          }

          .not-found-code {
            font-size: 8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #007bff;
          }

          .not-found-message {
            font-size: 1.5rem;
            margin-bottom: 2rem;
          }

          .not-found-link {
            color: #00ffff;
            text-decoration: none;
            transition: color 0.3s ease;
          }

          .not-found-link:hover {
            color: #fff;
          }
        `}
      </style>
      <div className="not-found-code">404 - Pagina niet gevonden</div>
      <div className="not-found-message">Whoops, deze pagina is niet beschikbaar.</div>
      <a href="/" className="not-found-link">Go back to the homepage</a>
    </div>
  );
};

export default NotFound;