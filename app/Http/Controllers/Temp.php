<?php
declare(strict_types=1);

namespace App\Repository;

use App\BidStatus;
use App\FinancialData;
use App\Helpers\BankByHost;
use App\Models\BankBranch\BankBranch;
use App\Models\GuarantorBanks;
use App\Models\Settings;
use App\MyRequest;
use App\Notification;
use App\Service\Documents\MyRequests\Catalog\Profs\MotivatedJudgement;
use App\Service\MyRequest\Creation\DefinitionValues;
use App\Service\MyRequest\Creation\InheritanceFromKontur;
use App\Service\MyRequest\Creation\InheritanceFromPrevious;
use App\Service\MyRequest\Creation\InitialDataGeneration;
use App\Service\MyRequest\Creation\PaymentAccount\InitialDataGeneration as PADataGeneration;
use App\Service\MyRequest\Creation\PaymentAccount\InheritanceFromKontur as PAInheritanceFromKontur;
use App\Service\MyRequest\Exceptions\ActiveBidWithSameParamsExistException;
use App\Service\RelationCompany;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class MyRequestRepository
 *
 * @package App\Repository
 */
class MyRequestRepository
{
    /**
     * @var \App\MyRequest
     */
    protected $myRequest;


    /**
     * MyRequestRepository constructor.
     *
     * @param \App\MyRequest $myRequest
     */
    public function __construct(MyRequest $myRequest = null)
    {
        if (!$myRequest) {
            $myRequest = new MyRequest();
        }
        $this->myRequest = $myRequest;
    }


    /**
     * @param $date_from
     * @param $date_to
     * @param int $agent - agent id
     * @param string $bankSlug
     * @return mixed
     */
    public function getDataForCalcAgent($date_from, $date_to, $agent = null, $bankSlug = null)
    {
        $query = $this->myRequest::query();

        if (!empty($bankSlug) and $bankSlug !== 'all') {
            $query->where('my_requests.guarantor_bank_slug', '=', $bankSlug);
        }

        $contractTypes = [
            MyRequest::CONTRACT_TYPE_PUBLIC,
            MyRequest::CONTRACT_TYPE_COMMERCIAL,
        ];

        $query->whereBetween('log.released_date', [$date_from, $date_to])
            ->whereIn('my_requests.contract_type', $contractTypes)
            ->where('users.type', 'agent')
            ->whereIn('my_requests.status',
                [BidStatus::STATUS_RELEASED, BidStatus::STATUS_SENDING, BidStatus::STATUS_SENT, BidStatus::STATUS_CLOSED])
            ->join('customers', 'my_requests.id', '=', 'customers.my_request_id')
            ->leftJoin('agents', 'my_requests.user_id', '=', 'agents.user_id')
            ->leftJoin('users', 'agents.user_id', '=', 'users.id')
            ->leftJoin('agent_request_rewards', 'agent_request_rewards.my_request_id', '=', 'my_requests.id')
            ->join('request_datas', 'my_requests.id', '=', 'request_datas.my_request_id')
            ->join('entities', 'my_requests.entity_id', '=', 'entities.id')
            ->join('guarantor_banks', 'my_requests.guarantor_bank_slug', '=', 'guarantor_banks.slug')
            ->leftJoin(
                \DB::raw("(select object_id, max(created_at) as released_date
                from logs where out = '7' and object = 'bid' group by object_id) log"),
                'log.object_id', '=', 'my_requests.id')
            ->orderBy('my_requests.id', 'asc')
            ->select(
                'my_requests.id',
                'my_requests.guarantor_bank_slug',
                'my_requests.contract_type',
                'users.fio',
                'users.bank_slug',
                'agents.id as agent_id',
                'agents.account_60311',
                'agents.entity_inn as inn',
                'agents.entity_full_name as name',
                'agents.entity_short_name as short_name',
                'agents.with_nds',
                'customers.execSum',
                'agent_request_rewards.desired_commission',
                'agent_request_rewards.basic_commission',
                'agent_request_rewards.reward_percent',
                'agent_request_rewards.bg_reward_percent',
                'agent_request_rewards.fixed_bg_reward',
                'agent_request_rewards.desired_reward_value',
                'agent_request_rewards.reward_excess',
                'request_datas.date_start',
                'log.released_date',
                'guarantor_banks.name as guarantor_bank_name'
            );

        if ($agent) {
            $query->where('agents.id', $agent);

            $query->select(
                'my_requests.id',
                'my_requests.contract_type',
                'users.fio',
                'users.bank_slug',
                'agents.id as agent_id',
                'agents.entity_inn as inn',
                'agents.entity_ogrn as ogrn',
                'agents.entity_full_name as name',
                'agents.entity_short_name as short_name',
                'agents.with_nds',
                'agents.taxation_system',
                'agents.individual_fio as fio',
                'agents.individual_position as position',
                'customers.execSum',
                'agent_request_rewards.desired_commission',
                'agent_request_rewards.basic_commission',
                'agent_request_rewards.reward_percent',
                'agent_request_rewards.bg_reward_percent',
                'agent_request_rewards.desired_reward_value',
                'agent_request_rewards.reward_excess',
                'agent_request_rewards.fixed_bg_reward',
                'request_datas.bg_types',
                'entities.entity_full_name',
                'entities.entity_short_name',
                'entities.entity_inn',
                'request_datas.commission',
                'log.released_date'
            );
        }


        $res = $query->get();

        $refBids = $this->getDataForCalcReferralAgent($date_from, $date_to, $agent,$bankSlug);

        return $res->merge($refBids);
    }

    /**
     * @param $date_from
     * @param $date_to
     * @param int $agent - agent id
     * @param string $bankSlug
     * @return mixed
     */
    protected function getDataForCalcReferralAgent($date_from, $date_to, $agent = null, $bankSlug = null)
    {
        $query = $this->myRequest::query();

        if (!empty($bankSlug) and $bankSlug !== 'all') {
            $query->where('my_requests.guarantor_bank_slug', '=', $bankSlug);
        }

        $contractTypes = [
            MyRequest::CONTRACT_TYPE_PUBLIC,
            MyRequest::CONTRACT_TYPE_COMMERCIAL,
        ];

        $refBids = MyRequest::query()->whereBetween('log.released_date', [$date_from, $date_to])
            ->whereIn('my_requests.contract_type', $contractTypes)
            ->where('users.type', 'agent')
            ->whereIn('my_requests.status',
                [BidStatus::STATUS_RELEASED, BidStatus::STATUS_SENDING, BidStatus::STATUS_SENT, BidStatus::STATUS_CLOSED])
            ->join('customers', 'my_requests.id', '=', 'customers.my_request_id')
            ->leftJoin('agents', 'my_requests.user_id', '=', 'agents.user_id')
            ->leftJoin('users', 'agents.user_id', '=', 'users.id')
            ->leftJoin('agents as ref_agent', 'users.referral_agent_id', '=', 'ref_agent.id')
            ->leftJoin('users as ref_user', 'ref_agent.user_id', '=', 'ref_user.id')
            ->leftJoin('agent_request_rewards', 'agent_request_rewards.my_request_id', '=', 'my_requests.id')
            ->join('request_datas', 'my_requests.id', '=', 'request_datas.my_request_id')
            ->join('entities', 'my_requests.entity_id', '=', 'entities.id')
            ->join('guarantor_banks', 'my_requests.guarantor_bank_slug', '=', 'guarantor_banks.slug')
            ->leftJoin(
                \DB::raw("(select object_id, max(created_at) as released_date
                    from logs where out = '7' and object = 'bid' group by object_id) log"),
                'log.object_id', '=', 'my_requests.id')
            ->whereNotNull('ref_agent.id')
            ->where('ref_agent.is_affilate_programm',true)
            ->select(
                'my_requests.id',
                'my_requests.guarantor_bank_slug',
                'my_requests.contract_type',
                'ref_user.fio',
                'ref_agent.id as agent_id',
                'ref_agent.account_60311',
                'ref_agent.entity_inn as inn',
                'ref_agent.entity_full_name as name',
                'ref_agent.entity_short_name as short_name',
                'ref_agent.with_nds',
                'customers.execSum',
                DB::raw('0 as basic_commission'),
                DB::raw('10.00 as bg_reward_percent'),
                DB::raw('(agent_request_rewards.desired_commission * 0.1) as desired_reward_value'),
                DB::raw('0 as reward_excess'),
                'agent_request_rewards.desired_commission',
                'agent_request_rewards.reward_percent',
                'agent_request_rewards.fixed_bg_reward',
                'request_datas.date_start',
                'log.released_date',
                'guarantor_banks.name as guarantor_bank_name'
            );

        if ($agent) {
            $refBids->where('ref_agent.id', $agent)
                ->select(
                    'my_requests.id',
                    'my_requests.contract_type',
                    'ref_user.fio',
                    'ref_agent.id as agent_id',
                    'ref_agent.entity_inn as inn',
                    'ref_agent.entity_ogrn as ogrn',
                    'ref_agent.entity_full_name as name',
                    'ref_agent.entity_short_name as short_name',
                    'ref_agent.with_nds',
                    'ref_agent.taxation_system',
                    'ref_agent.individual_fio as fio',
                    'ref_agent.individual_position as position',
                    'customers.execSum',
                    'agent_request_rewards.desired_commission',
                    DB::raw('0 as basic_commission'),
                    DB::raw('10.00 as bg_reward_percent'),
                    DB::raw('(agent_request_rewards.desired_commission * 0.1) as desired_reward_value'),
                    DB::raw('0 as reward_excess'),
                    'request_datas.bg_types',
                    'entities.entity_full_name',
                    'entities.entity_short_name',
                    'entities.entity_inn',
                    'request_datas.commission',
                    'log.released_date');
        }

        return $refBids->get();
    }

    /**
     * сумма заявок в статусах предложение принято, ожидает подписания, выдана, отправка, отправлена.
     *
     * @param $inn
     * @return mixed
     */
    public function getSumForLimit($inn)
    {
        $staus = [
            BidStatus::STATUS_PROPOSAL_ACCEPTED,
            BidStatus::STATUS_WAITING_SIGNING,
            BidStatus::STATUS_RELEASED,
            BidStatus::STATUS_SENDING,
            BidStatus::STATUS_SENT,
        ];

        $query = $this->myRequest::query();

        $query
            ->join('customers', 'my_requests.id', '=', 'customers.my_request_id')
            ->join('entities', 'my_requests.entity_id', '=', 'entities.id')
            ->where('entity_inn', $inn)
            ->whereIn('status', $staus)
            ->select('customers.execSum');

        return $query->get()->sum('execSum');
    }

    /**
     * Получить количество БГ выданных за заданный месяц с наименованиями банков гарантов
     * @param Carbon $month_start
     * @param array $bankSlugs
     * @return Collection
     */
    public function getReleasedGroupedByGarantBank(Carbon $month_start, $bankSlugs)
    {

        $date_from = $month_start->startOfMonth()->format('Y-m-d');
        $date_to = $month_start->copy()->endOfMonth();

        $subQuery = $this->myRequest->query()->whereBetween('log.released_date', [$date_from, $date_to])
            ->whereIn('my_requests.status', [BidStatus::STATUS_RELEASED, BidStatus::STATUS_SENDING, BidStatus::STATUS_SENT])
            ->join('guarantor_banks', 'my_requests.guarantor_bank_slug', '=', 'guarantor_banks.slug')
            ->leftJoin(
                \DB::raw("(select object_id, max(created_at) as released_date
                from logs where out = '7' and object = 'bid' group by object_id) log"),
                'log.object_id', '=', 'my_requests.id')
            ->leftJoin('agent_request_rewards', 'agent_request_rewards.my_request_id', '=', 'my_requests.id')
            ->groupBy(['my_requests.guarantor_bank_slug'])
            ->select(
                'my_requests.guarantor_bank_slug',
                DB::raw('COUNT(*) as request_qty'),
                DB::raw('SUM(agent_request_rewards.desired_reward_value + agent_request_rewards.reward_excess) as reward_sum')
            );

        $query = GuarantorBanks::whereIn('slug', $bankSlugs)
            ->leftJoinSub($subQuery, 'sub', 'sub.guarantor_bank_slug', '=', 'slug')
            ->selectRaw('guarantor_banks.slug as guarantor_bank_slug, COALESCE(sub.request_qty, 0) as request_qty, 
                            COALESCE(sub.reward_sum, 0) as reward_sum');


        return $query->get();
    }

    /**
     * Перевод заявки в статус Отказ прескоринга
     * с записью причины отказа
     * @param $message
     * @return bool
     */
    public function declinePrescoreWithMessage(MyRequest $myRequest, $message)
    {
        $myRequest->updateStatus(BidStatus::STATUS_PRESCORE_DECLINED);
        $myRequest->prescore_error .= '<br>' . $message;
        return $myRequest->save();
    }

    /**
     * Обновление статуса "Требуется согласование рисков"
     * @parem MyRequest $myRequest
     * @param bool $state
     * @return bool
     */
    public function updateCoordinationRiskState(MyRequest $myRequest, $state)
    {
        $requestData = $myRequest->requestData;
        if ($requestData->coordination_risk === null) {
            $requestData->coordination_risk = $state;
            return $requestData->save();
        }
        return false;
    }

    /**
     * Проверка, нужно ли обновить флаг "Требуется согласие рисков"
     * если нужно - обновляем
     *
     * @param MyRequest $myRequest
     * @param $state
     * @return bool         -   true если флаг установлен в true
     */
    public function checkUpdateCoordinationRiskState(MyRequest $myRequest, $state)
    {
        $entity = $myRequest->entities;
        $customer = $myRequest->customer;
        $check = false;
        $settings = Settings::where(function ($query) {
            $query->where('name', '=', 'SECURITY_RISKS_BG_SUMM')
                ->orWhere('name', '=', 'SECURITY_RISKS_LIMIT');
        })
            ->whereGuarantorBankSlug($myRequest->guarantor_bank_slug)
            ->get();

        foreach ($settings as $setting) {
            if ( $setting->name == 'SECURITY_RISKS_BG_SUMM' && $setting->enabled == true) {
                $activeBgSum = $customer->execSum;
                if($activeBgSum > $setting->value) {
                    $check = true;
                }
            } elseif ($setting->name == 'SECURITY_RISKS_LIMIT' && $setting->enabled == true){
                $activeLimit = $entity->getActiveBgSum($customer->execSum, $myRequest->id, $myRequest->guarantor_bank_slug);
                if($activeLimit > $setting->value){
                    $check = true;
                }
            }

        }
        $requestData = $myRequest->requestData;

        if(!$check){
            return false;
        } else {
            if ($requestData->coordination_risk === null) {
                $requestData->coordination_risk = $state;
                Notification::sendNotifyEmailToRisk($myRequest);

                return $requestData->save();
            }

            return $requestData->coordination_risk;
        }
    }

    /**
     * @param MyRequest $myRequest
     * @param $user
     * @param $data
     * @return bool
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function generateMotivatedJudgement(MyRequest $myRequest, $user, $data)
    {
        $document = new MotivatedJudgement($myRequest, auth()->user(), $data);
        $document->generate()->save();
        if ($data['status'] == 'accept') {
            $myRequest->updateStatus(BidStatus::STATUS_PROPOSAL_PREPARATION);
        } else if ($data['status'] == 'refuse') {
            $myRequest->updateStatus(BidStatus::STATUS_BANK_DECLINED);
        }
        $myRequest->requestData->update(['coordination_risk' => false]);
        return $document->getPath();
    }

    /**
     * @param MyRequest $myRequest
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public function deleteMotivatedJudgement(MyRequest $myRequest)
    {
        $document = new MotivatedJudgement($myRequest);
        $document->delete();
        return $myRequest->requestData->update(['doc_motivated_judgement_bank' => null, 'coordination_risk' => true]);
    }

    /**
     * Создаем заявку Кредит на оплату комиссии на основе текущей $sourceMyRequest
     * @param MyRequest $sourceMyRequest
     * @param array $data
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function createCommissionCreditFromExisting(MyRequest $sourceMyRequest, array $data)
    {
        $data = [
            'execSum' => $data['commission'],
            'partSum' => $data['commission'],

            'contract_type' => MyRequest::CONTRACT_TYPE_COMMISSION_CREDIT,
            'bg_types' => 0,
            'bidding_law' => $sourceMyRequest->requestData->bidding_law,
            'entity_inn' => $sourceMyRequest->entities->entity_inn,
            'entity_full_name' => $sourceMyRequest->entities->entity_full_name,
            'entity_short_name' => $sourceMyRequest->entities->entity_short_name,
            'entity_address' => $sourceMyRequest->entities->entity_address,
            'purchase' => $sourceMyRequest->customer->purchase,
            'date_publish' => $sourceMyRequest->requestData->date_publish,
            'date_output' => $sourceMyRequest->requestData->date_output,
            'date_finish' => $sourceMyRequest->requestData->date_finish,
            'bg_mounth' => $sourceMyRequest->requestData->bg_mounth,
            'bg_form_ben' => $sourceMyRequest->requestData->bg_form_ben,
            'avans' => $sourceMyRequest->requestData->avans,
            'bg_cancelation' => $sourceMyRequest->requestData->bg_cancelation,
            'provider_ident_type' => $sourceMyRequest->requestData->provider_ident_type,
            'start_price' => $sourceMyRequest->requestData->start_price,
            'final_price' => $sourceMyRequest->requestData->final_price,
            'customer_inn' => $sourceMyRequest->customer->customer_inn,
            'customer_kpp' => $sourceMyRequest->customer->customer_kpp,
            'customer_oktmo' => $sourceMyRequest->customer->customer_oktmo,
            'customer_ogrn' => $sourceMyRequest->customer->customer_ogrn,
            'customer_full_name' => $sourceMyRequest->customer->customer_full_name,
            'customer_address' => $sourceMyRequest->customer->customer_address,
            'guarantor_bank_slug' => 'simpleFinance'
        ];

        try {
            DB::beginTransaction();
            // Создаем новую заявку.
            $initService = new InitialDataGeneration($data);

            /** @var MyRequest $newMyRequest */
            $newMyRequest = collect($initService->create())->first();

            // Подтягиваем данные из предыдущей заявки.
            $fromPrevious = new InheritanceFromPrevious($newMyRequest);
            $fromPrevious->setPreviousRequest($sourceMyRequest);
            $fromPrevious->fill();

            // Заполняем вычисляемыми значениями заявку.
            $definition = new DefinitionValues($newMyRequest);
            $definition->handle();

            // Привязкак текущей заявке
            $sourceMyRequest->linked_request_id = $newMyRequest->id;
            $sourceMyRequest->save();

            // Выставляем поочередно статусы
            $newMyRequest->updateStatus(BidStatus::STATUS_DRAFT);
            $newMyRequest->updateStatus(BidStatus::STATUS_PASSED_TO_BANK);

            DB::commit();
        } catch (\Exception $e) {
            Log::error("Ошибка при создании заявки Кредит на оплату комиссии. На основе текущей заявки №{$sourceMyRequest}" .
                PHP_EOL . $e->getMessage());
            DB::rollback();
            return false;
        }
        return $newMyRequest->id;
    }

    /**
     * Создаем заявку Кридита на исполнение контракта на основании текущей $sourceMyRequest
     * @param MyRequest $sourceMyRequest
     * @return MyRequest|null
     */
    public function createKIKFromExisting(MyRequest $sourceMyRequest): ?MyRequest
    {
        $data = [
            'contract_type' => MyRequest::CONTRACT_TYPE_CREDIT_BANK,
            'linked_request_id' => $sourceMyRequest->id,
            'bg_types' => 0,
            'bidding_law' => $sourceMyRequest->requestData->bidding_law,
            'entity' => [
                'entity_inn' => $sourceMyRequest->entities->entity_inn,
                'entity_full_name' => $sourceMyRequest->entities->entity_full_name,
                'entity_short_name' => $sourceMyRequest->entities->entity_short_name,
                'entity_address' => $sourceMyRequest->entities->entity_address,
            ],
            'purchase' => $sourceMyRequest->customer->purchase,
            'execSum' => $sourceMyRequest->customer->execSum,
            'partSum' => $sourceMyRequest->customer->partSum,
            'date_publish' => $sourceMyRequest->requestData->date_publish,
            'date_output' => $sourceMyRequest->requestData->date_output,
            'date_finish' => $sourceMyRequest->requestData->date_finish,
            'bg_mounth' => $sourceMyRequest->requestData->bg_mounth,
            'bg_form_ben' => $sourceMyRequest->requestData->bg_form_ben,
            'avans' => $sourceMyRequest->requestData->avans,
            'bg_cancelation' => $sourceMyRequest->requestData->bg_cancelation,
            'provider_ident_type' => $sourceMyRequest->requestData->provider_ident_type,
            'start_price' => $sourceMyRequest->requestData->start_price,
            'final_price' => $sourceMyRequest->requestData->final_price,
            'customer_inn' => $sourceMyRequest->customer->customer_inn,
            'customer_kpp' => $sourceMyRequest->customer->customer_kpp,
            'customer_oktmo' => $sourceMyRequest->customer->customer_oktmo,
            'customer_ogrn' => $sourceMyRequest->customer->customer_ogrn,
            'customer_full_name' => $sourceMyRequest->customer->customer_full_name,
            'customer_address' => $sourceMyRequest->customer->customer_address,
        ];

        try {
            DB::beginTransaction();
            // Создаем новую заявку.
            $initService = new InitialDataGeneration($data,true);

            /** @var MyRequest $newMyRequest */
            $newMyRequest = collect($initService->create())->first();

            // Подтягиваем данные из предыдущей заявки.
            $fromPrevious = new InheritanceFromPrevious($newMyRequest);
            $fromPrevious->setPreviousRequest($sourceMyRequest);
            $fromPrevious->fill();

            // Заполняем вычисляемыми значениями заявку.
            $definition = new DefinitionValues($newMyRequest);
            $definition->handle();

            $newMyRequest->updateStatus(BidStatus::STATUS_DRAFT);

            DB::commit();
        } catch (\Exception $e) {
            Log::error("Ошибка при создании заявки КИК. На основе текущей заявки №{$sourceMyRequest}" .
                PHP_EOL . $e->getMessage());
            DB::rollback();
            return null;
        }
        return $newMyRequest;
    }

    /**
     * Создаем заявку Расчетный счет со спецусловиями
     * на основании текущей $sourceMyRequest
     *
     * @param MyRequest $sourceMyRequest
     * @return MyRequest|null
     */
    public function createPASpecialFromExisting(MyRequest $sourceMyRequest): ?MyRequest
    {
        $data = [
            'guarantor_bank_slug' => $sourceMyRequest->guarantor_bank_slug,
            'contract_type' => MyRequest::CONTRACT_TYPE_PA_SPECIAL,
            'linked_request_id' => $sourceMyRequest->id,
            'entity' => [
                'entity_address' => $sourceMyRequest->entities->entity_address,
                'entity_full_name' => $sourceMyRequest->entities->entity_full_name,
                'entity_inn' => $sourceMyRequest->entities->entity_inn,
                'entity_short_name' => $sourceMyRequest->entities->entity_short_name,
                'entity_ogrn' => $sourceMyRequest->entities->entity_ogrn,
                'entity_ogrnip' => $sourceMyRequest->entities->entity_ogrnip,
            ],
            'annual_avg_profit_sum' => FinancialData::getLastYearIncome($sourceMyRequest->entity),
            'wholesale' => true,
        ];

        try {
            DB::beginTransaction();
            // Создаем новую заявку.
            $initService = new PADataGeneration($data);

            /** @var MyRequest $newMyRequest */
            $newMyRequest = $initService->create();

            // Подтягиваем данные из предыдущей заявки.
            $fromPrevious = new InheritanceFromPrevious($newMyRequest);
            $fromPrevious->setPreviousRequest($sourceMyRequest);
            $fromPrevious->fill();

            // Заполняем вычисляемыми значениями заявку.
            $definition = new DefinitionValues($newMyRequest);
            $definition->handle();

            // Заполним из контура часть полей
            $fromKontur = new PAInheritanceFromKontur($newMyRequest);
            $fromKontur->fillCustomDataFromKontur();

            // Добавить связь заявки с отделением банка
            if (!empty($sourceMyRequest->bank_branch_id)) {
                $bankBranch = BankBranch::find($sourceMyRequest->bank_branch_id);
                $newMyRequest->bankBranch()->associate($bankBranch);
                $newMyRequest->save();
            }

            $newMyRequest->updateStatus(BidStatus::STATUS_DRAFT);

            $sourceMyRequest->update(['linked_request_id' => $newMyRequest->id]);

            DB::commit();
        } catch (\Throwable $e) {
            Log::error("Ошибка при создании заявки РКО со спец условиями. На основе текущей заявки №{$sourceMyRequest}" .
                PHP_EOL . $e->getMessage());
            DB::rollback();
            return null;
        }
        return $newMyRequest;
    }
}
