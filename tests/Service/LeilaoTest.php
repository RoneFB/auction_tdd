<?php 
namespace Sistema\Leilao\Tests\Model;

use PHPUnit\Framework\TestCase;
use Sistema\Leilao\Model\Usuario;
use Sistema\Leilao\Model\Leilao;
use Sistema\Leilao\Model\Lance;

class LeilaoTest extends TestCase {
    
    public function testLeilaoNaoDeveAceitarMaisde5LancesPorUsuario(){
        
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor mais de 5 lances por leilã');
        
        $leilao = new Leilao('Brasilia Amarela');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 1500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 3000));
        $leilao->recebeLance(new Lance($maria, 3500));
        $leilao->recebeLance(new Lance($joao, 4000));
        $leilao->recebeLance(new Lance($maria, 4500));
        $leilao->recebeLance(new Lance($joao, 5000));
        $leilao->recebeLance(new Lance($maria, 5500));
        
        $leilao->recebeLance(new Lance($joao, 6000));
        
        $lances = $leilao->getLances();
    }
    
    public function testLeilaoNaoDeveReceberLancesRepetidos() {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Usuário não pode propor 2 lances seguidos');
        
        $leilao = new Leilao('Variante');
        $ana = new Usuario('Ana');
        
        $leilao->recebeLance(new Lance($ana, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));
    }
    
    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $qtdLances, Leilao $leilao, array $valores) {
        
        static::assertCount($qtdLances, $leilao->getLances());
        
        foreach ($valores as $i => $valorEsperado){
            static::assertEquals($valorEsperado, $leilao->getLances() [$i]->getValor());
        }
        
        
    }
    
    public function geraLances()
    {
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        
        $leilao = new Leilao('Fiat 147 0km');
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 2000));
        
        $leilao2 = new Leilao('Fusca 1972 0km');
        $leilao2->recebeLance(new Lance($maria, 5000));
        
        return [
            '2-lances' => [2, $leilao, [1000, 2000]],
            '1-lance' => [1, $leilao2, [5000]]
        ];
    }
}
