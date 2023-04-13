<?php 
namespace App\Service;

use App\Service\AppService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class CompanyService extends AppService
{
	
	public function companyList() {
		$company = DB::table('company_kagaya.company')->select('company.cp_code', 'company.cp_name');
		if (!is_empty(Auth::user()) && Auth::user()->role_id == 2) {
            $company->where('company.cp_code', '=', Auth::user()->cp_code);
        }
        $company->whereNull('deleted_at');
		$company = $company->get()->toArray();

		return $company;
	}
}