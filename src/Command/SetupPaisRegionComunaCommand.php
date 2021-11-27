<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin\Comuna;
use App\Entity\Admin\Region;
use App\Entity\Admin\Pais;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Templating\EngineInterface;

class SetupPaisRegionComunaCommand extends Command
{
    protected static $defaultName = 'app:setup:comunas';
    
    private $regiones = [[
                "numero" => 15,        
                "nombre"=> "Región de Arica y Parinacota",
                "comunas"=> ["Arica", "Camarones", "Putre", "General Lagos"]
        ],
            [
                "numero" => 1,
                "nombre"=> "Región de Tarapacá",
                "comunas"=> ["Iquique", "Alto Hospicio", "Pozo Almonte", "Camiña", "Colchane", "Huara", "Pica"]
        ],
            [
                "numero" => 2,
                "nombre"=> "Región de Antofagasta",
                "comunas"=> ["Antofagasta", "Mejillones", "Sierra Gorda", "Taltal", "Calama", "Ollagüe", "San Pedro de Atacama", "Tocopilla", "María Elena"]
        ],
            [
                "numero" => 3,
                "nombre"=> "Región de Atacama",
                "comunas"=> ["Copiapó", "Caldera", "Tierra Amarilla", "Chañaral", "Diego de Almagro", "Vallenar", "Alto del Carmen", "Freirina", "Huasco"]
        ],
            [
                "numero" => 4,
                "nombre"=> "Región de Coquimbo",
                "comunas"=> ["La Serena", "Coquimbo", "Andacollo", "La Higuera", "Paiguano", "Vicuña", "Illapel", "Canela", "Los Vilos", "Salamanca", "Ovalle", "Combarbalá", "Monte Patria", "Punitaqui", "Río Hurtado"]
        ],
            [
                "numero" => 5,
                "nombre"=> "Región de Valparaíso",
                "comunas"=> ["Valparaíso", "Casablanca", "Concón", "Juan Fernández", "Puchuncaví", "Quintero", "Viña del Mar", "Isla de Pascua", "Los Andes", "Calle Larga", "Rinconada", "San Esteban", "La Ligua", "Cabildo", "Papudo", "Petorca", "Zapallar", "Quillota", "Calera", "Hijuelas", "La Cruz", "Nogales", "San Antonio", "Algarrobo", "Cartagena", "El Quisco", "El Tabo", "Santo Domingo", "San Felipe", "Catemu", "Llaillay", "Panquehue", "Putaendo", "Santa María", "Quilpué", "Limache", "Olmué", "Villa Alemana"]
        ],
            [
                "numero" => 6,
                "nombre"=> "Región del Libertador Gral. Bernardo O’Higgins",
                "comunas"=> ["Rancagua", "Codegua", "Coinco", "Coltauco", "Doñihue", "Graneros", "Las Cabras", "Machalí", "Malloa", "Mostazal", "Olivar", "Peumo", "Pichidegua", "Quinta de Tilcoco", "Rengo", "Requínoa", "San Vicente", "Pichilemu", "La Estrella", "Litueche", "Marchihue", "Navidad", "Paredones", "San Fernando", "Chépica", "Chimbarongo", "Lolol", "Nancagua", "Palmilla", "Peralillo", "Placilla", "Pumanque", "Santa Cruz"]
        ],
            [
                "numero" => 7,
                "nombre"=> "Región del Maule",
                "comunas"=> ["Talca", "ConsVtución", "Curepto", "Empedrado", "Maule", "Pelarco", "Pencahue", "Río Claro", "San Clemente", "San Rafael", "Cauquenes", "Chanco", "Pelluhue", "Curicó", "Hualañé", "Licantén", "Molina", "Rauco", "Romeral", "Sagrada Familia", "Teno", "Vichuquén", "Linares", "Colbún", "Longaví", "Parral", "ReVro", "San Javier", "Villa Alegre", "Yerbas Buenas"]
        ],  
            [
                "numero" => 16,
                "nombre"=> "Región del Ñuble",
                "comunas"=> ["Gran Chillan", "San Carlos", "Coihueco", "Bulnes", "Yungay", "Quillón", "Coelemu", "El Carmen", "Quirihue", "Pemuco"]
        ],
            [
                "numero" => 8,
                "nombre"=> "Región del Biobío",
                "comunas"=> ["Alto Biobío","Antuco","Arauco","Cabrero","Cañete","Chiguayante","Concepción","Contulmo","Coronel","Curanilahue","Florida","Hualpén","Hualqui","Laja","Lebu","Los Álamos","Los Ángeles","Lota","Mulchén","Nacimiento","Negrete","Penco","Quilaco","Quilleco","San Pedro De La Paz","San Rosendo","Santa Bárbara","Santa Juana","Talcahuano","Tirúa","Tomé","Tucapel","Yumbel"]
        ],
            [
                "numero" => 9,
                "nombre"=> "Región de la Araucanía",
                "comunas"=> ["Temuco", "Carahue", "Cunco", "Curarrehue", "Freire", "Galvarino", "Gorbea", "Lautaro", "Loncoche", "Melipeuco", "Nueva Imperial", "Padre las Casas", "Perquenco", "Pitrufquén", "Pucón", "Saavedra", "Teodoro Schmidt", "Toltén", "Vilcún", "Villarrica", "Cholchol", "Angol", "Collipulli", "Curacautín", "Ercilla", "Lonquimay", "Los Sauces", "Lumaco", "Purén", "Renaico", "Traiguén", "Victoria", ]
        ],
            [
                "numero" => 14,
                "nombre"=> "Región de Los Ríos",
                "comunas"=> ["Valdivia", "Corral", "Lanco", "Los Lagos", "Máfil", "Mariquina", "Paillaco", "Panguipulli", "La Unión", "Futrono", "Lago Ranco", "Río Bueno"]
        ],
            [
                "numero" => 10,
                "nombre"=> "Región de Los Lagos",
                "comunas"=> ["Puerto Montt", "Calbuco", "Cochamó", "Fresia", "FruVllar", "Los Muermos", "Llanquihue", "Maullín", "Puerto Varas", "Castro", "Ancud", "Chonchi", "Curaco de Vélez", "Dalcahue", "Puqueldón", "Queilén", "Quellón", "Quemchi", "Quinchao", "Osorno", "Puerto Octay", "Purranque", "Puyehue", "Río Negro", "San Juan de la Costa", "San Pablo", "Chaitén", "Futaleufú", "Hualaihué", "Palena"]
        ],
            [
                "numero" => 11,
                "nombre"=> "Región Aisén del Gral. Carlos Ibáñez del Campo",
                "comunas"=> ["Coihaique", "Lago Verde", "Aisén", "Cisnes", "Guaitecas", "Cochrane", "O’Higgins", "Tortel", "Chile Chico", "Río Ibáñez"]
        ],
            [
                "numero" => 12,
                "nombre"=> "Región de Magallanes y de la AntárVca Chilena",
                "comunas"=> ["Punta Arenas", "Laguna Blanca", "Río Verde", "San Gregorio", "Cabo de Hornos (Ex Navarino)", "AntárVca", "Porvenir", "Primavera", "Timaukel", "Natales", "Torres del Paine"]
        ],
            [
                "numero" => 13,
                "nombre"=> "Región Metropolitana de Santiago",
                "comunas"=> ["Cerrillos", "Cerro Navia", "Conchalí", "El Bosque", "Estación Central", "Huechuraba", "Independencia", "La Cisterna", "La Florida", "La Granja", "La Pintana", "La Reina", "Las Condes", "Lo Barnechea", "Lo Espejo", "Lo Prado", "Macul", "Maipú", "Ñuñoa", "Pedro Aguirre Cerda", "Peñalolén", "Providencia", "Pudahuel", "Quilicura", "Quinta Normal", "Recoleta", "Renca", "San Joaquín", "San Miguel", "San Ramón", "Vitacura", "Puente Alto", "Pirque", "San José de Maipo", "Colina", "Lampa", "TilVl", "San Bernardo", "Buin", "Calera de Tango", "Paine", "Melipilla", "Alhué", "Curacaví", "María Pinto", "San Pedro", "Talagante", "El Monte", "Isla de Maipo", "Padre Hurtado", "Peñaflor"]
        ]
        ];

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $params;
    private $userManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        ParameterBagInterface $params
    )
    {
        $this->entityManager = $entityManager;
        $this->params = $params;
        parent::__construct();
    }

    protected function configure()
    {
        
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;
        
        $pais = new Pais();
        $pais->setCodigo('CHL');
        $pais->setNombre('CHILE');
        $em->persist($pais);

        foreach ($this->regiones as $key => $d) {
            $key = $d["numero"];
            $nombre = $d["nombre"];
            $comunas = $d["comunas"];
            $region = $em->getRepository(Region::class)->find($key);
            if ($region == null){
                $region = new Region();
                $region->setNombre($nombre);
                $region->setId($key);
                $region->setPais($pais);
                $em->persist($region);
            }
            foreach ($comunas as $key => $ncomuna) {
                $comuna = $em->getRepository(Comuna::class)->findOneBy(array('nombre' => $ncomuna));
                if ($comuna == null){
                    $comuna = new Comuna();
                    $comuna->setNombre($ncomuna);
                    $em->persist($comuna);
                }
                $comuna->setRegion($region);
            }
        }
        $em->flush();
        return true;
    }
}

