<?php
declare(strict_types=1);


namespace App\Reports\Infrastructure\Controller;

use App\Reports\Application\DTO\Report\ReportDTOTransformer;
use App\Reports\Application\UseCase\Command\AddModificationToReport\AddModificationToReportCommand;
use App\Reports\Application\UseCase\Command\CreateReport\CreateReportCommand;
use App\Reports\Application\UseCase\Command\UpdateReport\UpdateReportCommand;
use App\Reports\Application\UseCase\Query\FindReport\FindReportQuery;
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
        private readonly ReportDTOTransformer  $transformer,
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
            throw new AppException(current($errors)->getFullMessage());
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

    #[Route('/{id}', name: 'get', methods: ['GET'])]
    public function get(string $id): JsonResponse
    {
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $query = new FindReportQuery($id, $userUlid);
        $result = $this->queryBus->execute($query);

        return new JsonResponse($result->report);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, string $id): JsonResponse
    {
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $data = json_decode($request->getContent(), true);
        $data['creator_id'] = $userUlid;
        $data['approver_id'] = $userUlid;
        $errors = $this->validator->validate($data, $this->mapper->getValidationCollectionReport());
        if ($errors) {
            throw new AppException(current($errors)->getFullMessage());
        }
        $command = new UpdateReportCommand(
            $id,
            $this->transformer->fromArray($data),
            $userUlid
        );
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

    #[Route('/{id}/change-status/{status}', name: 'change-status', methods: ['GET'])]
    public function changeStatus(string $id, string $status, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $comment = $data['comment'] ?? null;
        AssertService::nullOrString($comment, 'Invalid type for comment provided.');
        $userUlid = $this->headersService->getUserUlid();
        AssertService::notNull($userUlid, 'No user\'s id provided.');
        $command = new AddModificationToReportCommand(
            $userUlid,
            $id,
            $status,
            $comment
        );
        $result = $this->commandBus->execute($command);

        return new JsonResponse($result);
    }

}