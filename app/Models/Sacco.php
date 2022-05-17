<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sacco
 * @package App\Models
 * @version July 17, 2019, 1:17 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection activations
 * @property \Illuminate\Database\Eloquent\Collection assetValuations
 * @property \Illuminate\Database\Eloquent\Collection assets
 * @property \Illuminate\Database\Eloquent\Collection auditTrails
 * @property \Illuminate\Database\Eloquent\Collection bankAccounts
 * @property \Illuminate\Database\Eloquent\Collection borrowerGroupMembers
 * @property \Illuminate\Database\Eloquent\Collection borrowerGroups
 * @property \Illuminate\Database\Eloquent\Collection borrowers
 * @property \Illuminate\Database\Eloquent\Collection branchUsers
 * @property \Illuminate\Database\Eloquent\Collection branches
 * @property \Illuminate\Database\Eloquent\Collection brands
 * @property \Illuminate\Database\Eloquent\Collection capitals
 * @property \Illuminate\Database\Eloquent\Collection charges
 * @property \Illuminate\Database\Eloquent\Collection chartOfAccounts
 * @property \Illuminate\Database\Eloquent\Collection collaterals
 * @property \Illuminate\Database\Eloquent\Collection collateralTypes
 * @property \Illuminate\Database\Eloquent\Collection customFields
 * @property \Illuminate\Database\Eloquent\Collection customFieldsMeta
 * @property \Illuminate\Database\Eloquent\Collection emails
 * @property \Illuminate\Database\Eloquent\Collection expenseTypes
 * @property \Illuminate\Database\Eloquent\Collection expenses
 * @property \Illuminate\Database\Eloquent\Collection guarantors
 * @property \Illuminate\Database\Eloquent\Collection journalEntries
 * @property \Illuminate\Database\Eloquent\Collection loanApplications
 * @property \Illuminate\Database\Eloquent\Collection loanCharges
 * @property \Illuminate\Database\Eloquent\Collection loanComments
 * @property \Illuminate\Database\Eloquent\Collection loanDisbursedBies
 * @property \Illuminate\Database\Eloquent\Collection loanFees
 * @property \Illuminate\Database\Eloquent\Collection loanFeesMeta
 * @property \Illuminate\Database\Eloquent\Collection loanProductCharges
 * @property \Illuminate\Database\Eloquent\Collection loanProducts
 * @property \Illuminate\Database\Eloquent\Collection loanRepaymentMethods
 * @property \Illuminate\Database\Eloquent\Collection loanRepayments
 * @property \Illuminate\Database\Eloquent\Collection loanSchedules
 * @property \Illuminate\Database\Eloquent\Collection loanStatuses
 * @property \Illuminate\Database\Eloquent\Collection loanTransactions
 * @property \Illuminate\Database\Eloquent\Collection loans
 * @property \Illuminate\Database\Eloquent\Collection messages
 * @property \Illuminate\Database\Eloquent\Collection otherIncomes
 * @property \Illuminate\Database\Eloquent\Collection otherIncomeTypes
 * @property \Illuminate\Database\Eloquent\Collection payrolls
 * @property \Illuminate\Database\Eloquent\Collection payrollMeta
 * @property \Illuminate\Database\Eloquent\Collection payrollTemplateMeta
 * @property \Illuminate\Database\Eloquent\Collection payrollTemplates
 * @property \Illuminate\Database\Eloquent\Collection persistences
 * @property \Illuminate\Database\Eloquent\Collection productCategories
 * @property \Illuminate\Database\Eloquent\Collection productCategoriesMeta
 * @property \Illuminate\Database\Eloquent\Collection productCheckInItems
 * @property \Illuminate\Database\Eloquent\Collection productCheckIns
 * @property \Illuminate\Database\Eloquent\Collection productCheckOutItems
 * @property \Illuminate\Database\Eloquent\Collection productCheckOuts
 * @property \Illuminate\Database\Eloquent\Collection productPayments
 * @property \Illuminate\Database\Eloquent\Collection productWarehouses
 * @property \Illuminate\Database\Eloquent\Collection products
 * @property \Illuminate\Database\Eloquent\Collection provisionRates
 * @property \Illuminate\Database\Eloquent\Collection purchaseOrderItems
 * @property \Illuminate\Database\Eloquent\Collection purchaseOrders
 * @property \Illuminate\Database\Eloquent\Collection reminders
 * @property \Illuminate\Database\Eloquent\Collection roles
 * @property \Illuminate\Database\Eloquent\Collection savings
 * @property \Illuminate\Database\Eloquent\Collection savingsCharges
 * @property \Illuminate\Database\Eloquent\Collection savingsFees
 * @property \Illuminate\Database\Eloquent\Collection savingsProductCharges
 * @property \Illuminate\Database\Eloquent\Collection savingsProducts
 * @property \Illuminate\Database\Eloquent\Collection savingsTransactions
 * @property \Illuminate\Database\Eloquent\Collection settings
 * @property \Illuminate\Database\Eloquent\Collection sms
 * @property \Illuminate\Database\Eloquent\Collection smsGateways
 * @property \Illuminate\Database\Eloquent\Collection suppliers
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string name
 * @property string address
 * @property string location
 */
class Sacco extends Model
{
    use SoftDeletes;

    public $table = 'saccos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'address' => 'string',
        'location' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
//        'id' => 'required',
        'name' => 'required',
        'address' => 'required',
        'location' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/

}
