import { useState, useEffect } from "react";
import axios from "axios";

function App() {
  const [Clients, setClients] = useState([]);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/cnss")
      .then((res) => setClients(res.data));
  }, []);

  console.log(Clients);

  if (Clients !== undefined) {
    return (
      <table className="table">
        <tr>
          <th>code client</th>
          <th>entreprise</th>
          <th>collaborateur</th>
          <th>date de depot</th>
        </tr>
        {Clients.map((client, i) => (
          <tr key={i}>
            <td>{client.code}</td>
            <td>{client.nom}</td>
            <td>{client.collaborateur}</td>
            {client.cnss.map((cnss, i) => (
              <td>{cnss.date_debut_ + i}</td>
            ))}
          </tr>
        ))}
      </table>
    );
  }
}

export default App;
