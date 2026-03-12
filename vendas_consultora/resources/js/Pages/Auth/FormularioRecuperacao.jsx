import { useState } from "react";
import { router } from "@inertiajs/react";

export default function RecuperarSenha() {
    const [email, setEmail] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        router.post("/recuperar-senha", { email });
    };

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
            <h2>Recuperar Senha</h2>
            <form onSubmit={handleSubmit}>
                <label>Email</label>
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />
                <button type="submit">Enviar link</button>
            </form>
        </div>
    );
}
