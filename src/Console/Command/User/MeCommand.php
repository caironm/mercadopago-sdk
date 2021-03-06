<?php

declare(strict_types=1);

/*
 * This file is part of gpupo/mercadopago-sdk
 * Created by Gilmar Pupo <contact@gpupo.com>
 * For the information of copyright and license you should read the file
 * LICENSE which is distributed with this source code.
 * Para a informação dos direitos autorais e de licença você deve ler o arquivo
 * LICENSE que é distribuído com este código-fonte.
 * Para obtener la información de los derechos de autor y la licencia debe leer
 * el archivo LICENSE que se distribuye con el código fuente.
 * For more information, see <https://opensource.gpupo.com/>.
 *
 */

namespace Gpupo\MercadopagoSdk\Console\Command\User;

use Gpupo\MercadopagoSdk\Console\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MeCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName(self::prefix.'user:me')
            ->setDescription('MercadoPago user info');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectData = $this->getProjectData();

        if (!array_key_exists('user_id', $projectData)) {
            throw new \Exception('User Id required!');
        }

        $this->getFactory()->getLogger()->info('Project Data', $projectData);
        $manager = $this->getFactory()->factoryManager('generic');

        $output->writeln('---- <bg=blue> APP INFO </> -------');
        $this->writeInfo($output, $manager->getFromRoute(['GET', '/applications/{client_id}?access_token={access_token}'], $projectData));

        $output->writeln('---- <bg=blue> User INFO </> -------');
        $this->writeInfo($output, $manager->getFromRoute(['GET', '/users/{user_id}?access_token={access_token}'], $projectData));

        return 0;
    }
}
