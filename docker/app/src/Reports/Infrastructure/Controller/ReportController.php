<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\Controller;

use App\Reports\Application\UseCase\Command\CreateReport\CreateReportCommand;
use App\Reports\Domain\Mapper\ReportMapper;
use App\Reports\Domain\Validation\Validator;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Domain\Service\AssertService;
use App\Shared\Domain\Service\RequestHeadersService;
use App\Shared\Infrastructure\Exception\AppException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('report', name: 'app_api_report_')]
class ReportController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface     $queryBus,
        private readonly CommandBusInterface   $commandBus,
        private readonly RequestHeadersService $headersService,
        private readonly ReportMapper          $mapper,
        private readonly Validator             $validator,
    )
    {
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $data = json_decode($request->getContent(), true);
        $data['creator_id'] = $userUlid;
        $data['approver_id'] = $userUlid;
        $errors = $this->validator->validate($data, $this->mapper->getValidationCollectionReport());
        if ($errors) {
            throw new AppException(current($errors));
        }

        $command = new CreateReportCommand(
            $data['title'],
            $data['template'],
            $data['creator_id'],
            $data['approver_id'],
            $data['variables'],
        );
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

}