import { useState } from "react";
import { router } from "@inertiajs/react";

export default function ResetPassword({ token }) {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [password_confirmation, setPasswordConfirmation] = useState("");

    const handleSubmit = (e) => {
        e.preventDefault();
        router.post("/resetar-senha", {
            email,
            password,
            password_confirmation,
            token,
        });
    };

    return (
        <div style={{ maxWidth: "400px", margin: "50px auto" }}>
            <h2>Redefinir Senha</h2>
            <form onSubmit={handleSubmit}>
                <label>Email</label>
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                />

                <label>Nova senha</label>
                <input
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                />

                <label>Confirmar senha</label>
                <input
                    type="password"
                    value={password_confirmation}
                    onChange={(e) => setPasswordConfirmation(e.target.value)}
                    required
                />

                <button type="submit">Atualizar senha</button>
            </form>
        </div>
    );
}
