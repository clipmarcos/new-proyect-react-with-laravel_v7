import React from 'react';
import ReactDOM from 'react-dom';

function App() {
    return (
       <div>
            <h1>Login React</h1>
       </div>
    );
}

export default App;

if (document.getElementById('app-react')) {
    ReactDOM.render(<App />, document.getElementById('app-react'));
}
