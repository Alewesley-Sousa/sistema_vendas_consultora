<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\produtos;

class ProdutosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produtos = [
            ['nome' => 'Batom Matte Vermelho', 'preco' => 39.90, 'descricao' => 'Batom de longa duração com acabamento matte.', 'categoria_id' => 1, 'status_id' => 1, 'imagem_url' => 'imagens/batom_matte_vermelho.jpg'],
            ['nome' => 'Base Líquida Bege Médio', 'preco' => 59.90, 'descricao' => 'Base líquida com cobertura média e efeito natural.', 'categoria_id' => 1, 'status_id' => 1, 'imagem_url' => 'imagens/base_liquida_bege.jpg'],
            ['nome' => 'Paleta de Sombras Neutras', 'preco' => 89.90, 'descricao' => 'Paleta com 12 cores neutras para maquiagem diária.', 'categoria_id' => 1, 'status_id' => 2, 'imagem_url' => 'imagens/paleta_sombras_neutras.jpg'],
            ['nome' => 'Hidratante Facial Nutritivo', 'preco' => 79.90, 'descricao' => 'Creme hidratante para uso diário, rico em vitaminas.', 'categoria_id' => 2, 'status_id' => 1, 'imagem_url' => 'imagens/hidratante_facial.jpg'],
            ['nome' => 'Protetor Solar FPS 50', 'preco' => 69.90, 'descricao' => 'Protetor solar facial com alta proteção UVA/UVB.', 'categoria_id' => 2, 'status_id' => 1, 'imagem_url' => 'imagens/protetor_solar.jpg'],
            ['nome' => 'Máscara Facial de Argila', 'preco' => 45.90, 'descricao' => 'Máscara purificante com argila verde.', 'categoria_id' => 2, 'status_id' => 3, 'imagem_url' => 'imagens/mascara_argila.jpg'],
            ['nome' => 'Perfume Floral Feminino', 'preco' => 129.90, 'descricao' => 'Fragrância suave com notas florais.', 'categoria_id' => 3, 'status_id' => 1, 'imagem_url' => 'imagens/perfume_floral.jpg'],
            ['nome' => 'Perfume Amadeirado Masculino', 'preco' => 139.90, 'descricao' => 'Fragrância intensa com notas amadeiradas.', 'categoria_id' => 3, 'status_id' => 2, 'imagem_url' => 'imagens/perfume_amadeirado.jpg'],
            ['nome' => 'Shampoo Revitalizante', 'preco' => 34.90, 'descricao' => 'Shampoo para cabelos danificados com extratos naturais.', 'categoria_id' => 4, 'status_id' => 1, 'imagem_url' => 'imagens/shampoo_revitalizante.jpg'],
            ['nome' => 'Condicionador Hidratante', 'preco' => 36.90, 'descricao' => 'Condicionador para cabelos secos e quebradiços.', 'categoria_id' => 4, 'status_id' => 1, 'imagem_url' => 'imagens/condicionador_hidratante.jpg'],
            ['nome' => 'Óleo Capilar Nutritivo', 'preco' => 49.90, 'descricao' => 'Óleo nutritivo para pontas ressecadas.', 'categoria_id' => 4, 'status_id' => 3, 'imagem_url' => 'imagens/oleo_capilar.jpg'],
            ['nome' => 'Esmalte Vermelho Clássico', 'preco' => 12.90, 'descricao' => 'Esmalte de alta cobertura e brilho intenso.', 'categoria_id' => 5, 'status_id' => 1, 'imagem_url' => 'imagens/esmalte_vermelho.jpg'],
            ['nome' => 'Fortalecedor de Unhas', 'preco' => 19.90, 'descricao' => 'Tratamento para unhas fracas e quebradiças.', 'categoria_id' => 5, 'status_id' => 2, 'imagem_url' => 'imagens/fortalecedor_unhas.jpg'],
            ['nome' => 'Sabonete Líquido Corporal', 'preco' => 24.90, 'descricao' => 'Sabonete líquido suave para uso diário.', 'categoria_id' => 6, 'status_id' => 1, 'imagem_url' => 'imagens/sabonete_liquido.jpg'],
            ['nome' => 'Esfoliante Corporal', 'preco' => 39.90, 'descricao' => 'Esfoliante com partículas naturais para renovação da pele.', 'categoria_id' => 6, 'status_id' => 2, 'imagem_url' => 'imagens/esfoliante_corporal.jpg'],
            ['nome' => 'Creme Anti-idade Noturno', 'preco' => 99.90, 'descricao' => 'Creme noturno para redução de linhas de expressão.', 'categoria_id' => 7, 'status_id' => 1, 'imagem_url' => 'imagens/creme_antiidade.jpg'],
            ['nome' => 'Sérum Rejuvenescedor', 'preco' => 119.90, 'descricao' => 'Sérum concentrado para firmeza da pele.', 'categoria_id' => 7, 'status_id' => 3, 'imagem_url' => 'imagens/serum_rejuvenescedor.jpg'],
            ['nome' => 'Kit Maquiagem Profissional', 'preco' => 199.90, 'descricao' => 'Kit completo com pincéis e paleta profissional.', 'categoria_id' => 8, 'status_id' => 1, 'imagem_url' => 'imagens/kit_maquiagem_profissional.jpg'],
            ['nome' => 'Hidratante Orgânico', 'preco' => 59.90, 'descricao' => 'Hidratante corporal feito com ingredientes naturais.', 'categoria_id' => 9, 'status_id' => 1, 'imagem_url' => 'imagens/hidratante_organico.jpg'],
            ['nome' => 'Kit Presente Cosméticos', 'preco' => 149.90, 'descricao' => 'Kit especial com fragrância, hidratante e sabonete.', 'categoria_id' => 10, 'status_id' => 1, 'imagem_url' => 'imagens/kit_presente.jpg'],
        ];

        foreach ($produtos as $produto) {
            produtos::create($produto);
        }
    }
}
