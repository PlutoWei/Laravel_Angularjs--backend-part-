<?php

use App\Helpers\TruncateWithForeignKey;
use App\Models2\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
		use TruncateWithForeignKey;

    /**
     * Run the database seeds.
     *
     * @return voidsendNewNotification
     */
    public function run()
    {
      $this->TruncateWithForeignKey('roles');

      // 1
      $item = new Role;
      $item->role_title = 'Super Administrators';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.addPage","academicyears.addAcademicyear","academicyears.editAcademicYears","academicyears.delAcademicYears","staticPages.editPage","staticPages.delPage","Administrators.addAdministrator","Administrators.editAdministrator","Administrators.delAdministrator","AccountSettings.ChgProfileData","AccountSettings.chgEmailAddress","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","dbExport.dbExport","sections.addSection","sections.editSection","sections.delSection","Subjects.editSubject","Subjects.delSubject","adminTasks.globalSettings","adminTasks.mailSmsSettings","adminTasks.frontendCMS","adminTasks.bioItegration","adminTasks.activatedModules","adminTasks.paymentsSettings","adminTasks.mobileSettings","adminTasks.lookFeel","adminTasks.vacationSettings","Languages.addLanguage","Languages.editLanguage","Languages.delLanguage","newsboard.View","events.View","frontendCMSpages.addPage","frontendCMSpages.editPage","frontendCMSpages.delPage","mediaCenter.View","mediaCenter.delAlbum","mediaCenter.delMedia","mediaCenter.editMedia","roles.add_role","roles.modify_role","roles.delete_role","gradeLevels.addLevel","gradeLevels.editGrade","gradeLevels.delGradeLevel","Promotion.promoteStudents","mailsms.mailSMSSend","mailsms.mailsmsTemplates","FeeDiscount.addFeeDiscount","FeeDiscount.editFeeDiscount","FeeDiscount.assignUser","Invoices.dueInvoices","Invoices.addPayment","Invoices.editPayment","Invoices.View","Invoices.delPayment","Assignments.Download","studyMaterial.addMaterial","studyMaterial.Download","Homework.addHomework","Homework.editHomework","Homework.View","Homework.Answers","Payroll.makeUsrPayment","Payroll.salaryBase","Payroll.hourSalary","Payroll.delUsrPayment","Payroll.userSalary","classSch.editSch","classSch.delSch","parents.AddParent","teachers.addTeacher","examsList.addExam","examsList.examDetailsNot","examsList.showMarks","dashboard.stats","wel_office_cat.list","wel_office_cat.edit_cat","wel_office_cat.del_cat","wel_office_cat.add_cat","students.list","students.delStudent","students.stdLeaderBoard","students.Attendance","students.Marksheet","students.Import","students.listGradStd","students.editStudent","students.Approve","students.Export","students.medHistory","parents.list","parents.delParent","parents.Export","parents.Approve","parents.Import","parents.editParent","visitors.list","visitors.edit_vis","visitors.del_vis","visitors.add_vis","visitors.Download","visitors.Export","phn_calls.list","phn_calls.edit_call","phn_calls.View","phn_calls.del_call","phn_calls.Export","phn_calls.add_call","postal.list","postal.del_postal","postal.Download","postal.add_postal","postal.Export","postal.edit_postal","con_mess.list","con_mess.Export","con_mess.del_mess","classSch.list","trans_vehicles.list","trans_vehicles.del_vehicle","trans_vehicles.add_vehicle","trans_vehicles.edit_vehicle","teachers.EditTeacher","teachers.teacLeaderBoard","teachers.Export","teachers.Approve","teachers.list","teachers.delTeacher","teachers.Import","Transportation.members","Transportation.list","Transportation.delTrans","Transportation.addTransport","Transportation.editTransport","Hostel.HostelCat","Hostel.EditHostel","Hostel.listSubs","Hostel.AddHostel","Hostel.delHostel","Hostel.list","depart.list","depart.del_depart","depart.add_depart","depart.edit_depart","desig.list","desig.del_desig","desig.add_desig","desig.edit_desig","employees.list","employees.delEmployee","employees.addEmployee","employees.editEmployee","examsList.controlMarksExam","examsList.delExam","examsList.View","examsList.list","examsList.editExam","enquiries.list","enquiries.edit_enq","enquiries.Export","enquiries.del_enq","enquiries.add_enq","enquiries.Download","complaints.edit_complaint","complaints.list","complaints.Export","complaints.del_complaint","complaints.Download","complaints.add_complaint","inv_cat.list","inv_cat.del_cat","inv_cat.add_cat","inv_cat.edit_cat","suppliers.list","suppliers.del_supp","suppliers.add_supp","suppliers.edit_supp","suppliers.Export","stores.list","stores.del_store","stores.add_store","stores.edit_store","items_code.list","items_code.del_item","items_code.Export","items_code.add_item","items_code.edit_item","items_stock.list","items_stock.del_item","items_stock.Download","items_stock.add_item","items_stock.edit_item","items_stock.Export","iss_ret.list","iss_ret.del_item","iss_ret.Download","iss_ret.issue_item","iss_ret.edit_item","iss_ret.Export","FeeAllocation.list","FeeAllocation.delFeeAllocation","FeeAllocation.addFeeAllocation","FeeAllocation.editFeeAllocation","onlineExams.QuestionsArch","onlineExams.delExam","onlineExams.list","onlineExams.takeExam","onlineExams.addExam","onlineExams.editExam","onlineExams.showMarks","issue_book.list","issue_book.del_issue","issue_book.add_issue","issue_book.Export","issue_book.edit_issue","issue_book.book_return","Library.mngSub","Library.editBook","Library.addBook","Library.Download","Library.delLibrary","Library.list","students.std_cat","students.admission","Expenses.list","Expenses.delExpense","Expenses.addExpense","Expenses.expCategory","Expenses.editExpense","Vacation.reqVacation","Vacation.appVacation","Vacation.myVacation","Attendance.takeAttendance","Attendance.attReport","Administrators.list","Assignments.list","Assignments.delAssignment","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","Dormitories.editDorm","Dormitories.addDormitories","Dormitories.list","Dormitories.delDorm","FeeDiscount.list","FeeDiscount.delFeeDiscount","FeeGroups.list","FeeGroups.delFeeGroup","FeeGroups.addFeeGroup","FeeGroups.editFeeGroup","FeeTypes.editFeeType","FeeTypes.delFeeType","FeeTypes.list","FeeTypes.addFeeType","Homework.Download","Homework.delHomework","Homework.list","Incomes.addIncome","Incomes.delIncome","Incomes.list","Incomes.editIncome","Incomes.incomeCategory","Invoices.Export","Invoices.collInvoice","Invoices.payRevert","Invoices.list","Languages.list","Polls.editPoll","Polls.addPoll","Polls.list","Polls.delPoll","Subjects.list","Subjects.addSubject","academicyears.list","classes.list","events.addEvent","events.delEvent","events.editEvent","events.list","frontendCMSpages.list","gradeLevels.list","mediaCenter.addAlbum","mediaCenter.addMedia","mediaCenter.editAlbum","mobileNotifications.sendNewNotification","newsboard.list","newsboard.editNews","newsboard.delNews","newsboard.addNews","roles.list","sections.list","staffAttendance.takeAttendance","staffAttendance.attReport","staticPages.list","studyMaterial.list","studyMaterial.delMaterial","studyMaterial.editMaterial","Reports.Reports","classSch.addSch","classes.delClass","classes.addClass","classes.editClass","complaints.View","enquiries.View","visitors.View","con_mess.View","Certificates.list","Certificates.del_cert","Certificates.add_cert","Certificates.edit_cert","Library.Export","Library.Import"]';
      $item->save();

      // 2
      $item = new Role;
      $item->role_title = 'Administrators';
      $item->role_description = 'Default role for administrators';
      $item->def_for = 'admin';
      $item->role_permissions = '["students.TrackBus","staticPages.addPage","academicyears.addAcademicyear","academicyears.editAcademicYears","academicyears.delAcademicYears","staticPages.editPage","staticPages.delPage","AccountSettings.ChgProfileData","AccountSettings.chgEmailAddress","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","classes.addClass","classes.editClass","classes.delClass","sections.addSection","sections.editSection","sections.delSection","Subjects.editSubject","Subjects.delSubject","adminTasks.globalSettings","adminTasks.mailSmsSettings","adminTasks.frontendCMS","adminTasks.bioItegration","adminTasks.activatedModules","adminTasks.paymentsSettings","adminTasks.mobileSettings","adminTasks.lookFeel","adminTasks.vacationSettings","newsboard.View","events.View","mediaCenter.View","mediaCenter.delAlbum","mediaCenter.delMedia","mediaCenter.editMedia","gradeLevels.addLevel","gradeLevels.editGrade","gradeLevels.delGradeLevel","Promotion.promoteStudents","mailsms.mailSMSSend","mailsms.mailsmsTemplates","FeeDiscount.addFeeDiscount","FeeDiscount.editFeeDiscount","FeeDiscount.assignUser","Invoices.dueInvoices","Invoices.addPayment","Invoices.editPayment","Invoices.View","Invoices.delPayment","Assignments.Download","studyMaterial.addMaterial","studyMaterial.Download","Homework.addHomework","Homework.editHomework","Homework.View","Homework.Answers","Payroll.makeUsrPayment","Payroll.salaryBase","Payroll.hourSalary","Payroll.delUsrPayment","Payroll.userSalary","classSch.addSch","classSch.editSch","classSch.delSch","parents.AddParent","teachers.addTeacher","examsList.addExam","examsList.examDetailsNot","examsList.showMarks","dashboard.stats","students.list","students.delStudent","students.stdLeaderBoard","students.Attendance","students.Marksheet","students.Import","students.listGradStd","students.editStudent","students.Approve","students.Export","parents.list","parents.delParent","parents.Export","parents.Approve","parents.Import","parents.editParent","phn_calls.list","phn_calls.edit_call","phn_calls.View","phn_calls.del_call","phn_calls.Export","phn_calls.add_call","con_mess.list","con_mess.Export","con_mess.View","con_mess.del_mess","classSch.list","trans_vehicles.list","trans_vehicles.del_vehicle","trans_vehicles.add_vehicle","trans_vehicles.edit_vehicle","teachers.EditTeacher","teachers.teacLeaderBoard","teachers.Export","teachers.Approve","teachers.list","teachers.delTeacher","teachers.Import","Transportation.members","Transportation.list","Transportation.delTrans","Transportation.addTransport","Transportation.editTransport","desig.list","desig.del_desig","desig.add_desig","desig.edit_desig","employees.list","employees.delEmployee","employees.addEmployee","employees.editEmployee","examsList.controlMarksExam","examsList.delExam","examsList.View","examsList.list","examsList.editExam","complaints.edit_complaint","complaints.list","complaints.Export","complaints.del_complaint","complaints.View","complaints.Download","complaints.add_complaint","iss_ret.list","iss_ret.del_item","iss_ret.Download","iss_ret.issue_item","iss_ret.edit_item","iss_ret.Export","FeeAllocation.addFeeAllocation","FeeAllocation.editFeeAllocation","issue_book.list","issue_book.del_issue","issue_book.add_issue","issue_book.Export","issue_book.edit_issue","issue_book.book_return","Library.mngSub","Library.editBook","Library.addBook","Library.Download","Library.delLibrary","Library.list","students.std_cat","students.admission","Vacation.reqVacation","Vacation.appVacation","Vacation.myVacation","Attendance.takeAttendance","Attendance.attReport","Assignments.list","Assignments.delAssignment","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","FeeDiscount.list","FeeDiscount.delFeeDiscount","Homework.Download","Homework.delHomework","Homework.list","Invoices.Export","Invoices.collInvoice","Invoices.payRevert","Invoices.list","Polls.editPoll","Polls.addPoll","Polls.list","Polls.delPoll","Subjects.list","Subjects.addSubject","academicyears.list","classes.list","events.addEvent","events.delEvent","events.editEvent","events.list","gradeLevels.list","mediaCenter.addAlbum","mediaCenter.addMedia","mediaCenter.editAlbum","mobileNotifications.sendNewNotification","newsboard.list","newsboard.editNews","newsboard.delNews","newsboard.addNews","sections.list","staffAttendance.takeAttendance","staffAttendance.attReport","staticPages.list","studyMaterial.list","studyMaterial.delMaterial","studyMaterial.editMaterial","Reports.Reports","Certificates.list","Certificates.del_cert","Certificates.add_cert","Certificates.edit_cert","roles.list","roles.add_role","roles.modify_role","roles.delete_role","Marksheet.Marksheet","Library.Export","Library.Import"]';
      $item->save();

      // 3
      $item = new Role;
      $item->role_title = 'Prefect';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.addPage","academicyears.addAcademicyear","academicyears.editAcademicYears","academicyears.delAcademicYears","staticPages.editPage","staticPages.delPage","AccountSettings.ChgProfileData","AccountSettings.chgEmailAddress","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","classes.addClass","classes.editClass","classes.delClass","sections.addSection","sections.editSection","sections.delSection","Subjects.editSubject","Subjects.delSubject","newsboard.View","events.View","frontendCMSpages.addPage","frontendCMSpages.editPage","frontendCMSpages.delPage","mediaCenter.View","mediaCenter.delAlbum","mediaCenter.delMedia","mediaCenter.editMedia","gradeLevels.addLevel","gradeLevels.editGrade","gradeLevels.delGradeLevel","Promotion.promoteStudents","mailsms.mailSMSSend","mailsms.mailsmsTemplates","FeeDiscount.addFeeDiscount","FeeDiscount.editFeeDiscount","FeeDiscount.assignUser","Invoices.dueInvoices","Invoices.addPayment","Invoices.editPayment","Invoices.View","Invoices.delPayment","Assignments.Download","studyMaterial.addMaterial","studyMaterial.Download","Homework.addHomework","Homework.editHomework","Homework.View","Homework.Answers","Payroll.makeUsrPayment","Payroll.salaryBase","Payroll.hourSalary","Payroll.delUsrPayment","Payroll.userSalary","classSch.addSch","classSch.editSch","classSch.delSch","parents.AddParent","teachers.addTeacher","examsList.addExam","examsList.examDetailsNot","examsList.showMarks","dashboard.stats","wel_office_cat.list","wel_office_cat.edit_cat","wel_office_cat.del_cat","wel_office_cat.add_cat","students.list","students.delStudent","students.stdLeaderBoard","students.Attendance","students.Marksheet","students.Import","students.listGradStd","students.editStudent","students.Approve","students.Export","students.medHistory","parents.list","parents.delParent","parents.Export","parents.Approve","parents.Import","parents.editParent","visitors.list","visitors.edit_vis","visitors.View","visitors.del_vis","visitors.add_vis","visitors.Download","visitors.Export","phn_calls.list","phn_calls.edit_call","phn_calls.View","phn_calls.del_call","phn_calls.Export","phn_calls.add_call","postal.list","postal.del_postal","postal.Download","postal.add_postal","postal.Export","postal.edit_postal","con_mess.list","con_mess.Export","con_mess.View","con_mess.del_mess","classSch.list","trans_vehicles.list","trans_vehicles.del_vehicle","trans_vehicles.add_vehicle","trans_vehicles.edit_vehicle","teachers.EditTeacher","teachers.teacLeaderBoard","teachers.Export","teachers.Approve","teachers.list","teachers.delTeacher","teachers.Import","Transportation.members","Transportation.list","Transportation.delTrans","Transportation.addTransport","Transportation.editTransport","Hostel.HostelCat","Hostel.EditHostel","Hostel.listSubs","Hostel.AddHostel","Hostel.delHostel","Hostel.list","depart.list","depart.del_depart","depart.add_depart","depart.edit_depart","desig.list","desig.del_desig","desig.add_desig","desig.edit_desig","employees.list","employees.delEmployee","employees.addEmployee","employees.editEmployee","examsList.controlMarksExam","examsList.delExam","examsList.View","examsList.list","examsList.editExam","enquiries.list","enquiries.edit_enq","enquiries.Export","enquiries.del_enq","enquiries.View","enquiries.add_enq","enquiries.Download","complaints.edit_complaint","complaints.list","complaints.Export","complaints.del_complaint","complaints.View","complaints.Download","complaints.add_complaint","inv_cat.list","inv_cat.del_cat","inv_cat.add_cat","inv_cat.edit_cat","suppliers.list","suppliers.del_supp","suppliers.add_supp","suppliers.edit_supp","suppliers.Export","stores.list","stores.del_store","stores.add_store","stores.edit_store","items_code.list","items_code.del_item","items_code.Export","items_code.add_item","items_code.edit_item","items_stock.list","items_stock.del_item","items_stock.Download","items_stock.add_item","items_stock.edit_item","items_stock.Export","iss_ret.list","iss_ret.del_item","iss_ret.Download","iss_ret.issue_item","iss_ret.edit_item","iss_ret.Export","FeeAllocation.list","FeeAllocation.delFeeAllocation","FeeAllocation.addFeeAllocation","FeeAllocation.editFeeAllocation","onlineExams.QuestionsArch","onlineExams.delExam","onlineExams.list","onlineExams.takeExam","onlineExams.addExam","onlineExams.editExam","onlineExams.showMarks","issue_book.list","issue_book.del_issue","issue_book.add_issue","issue_book.Export","issue_book.edit_issue","issue_book.book_return","Library.mngSub","Library.editBook","Library.addBook","Library.Download","Library.delLibrary","Library.list","students.std_cat","students.admission","Expenses.list","Expenses.delExpense","Expenses.addExpense","Expenses.expCategory","Expenses.editExpense","Vacation.reqVacation","Vacation.appVacation","Vacation.myVacation","Attendance.takeAttendance","Attendance.attReport","Assignments.list","Assignments.delAssignment","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","Dormitories.editDorm","Dormitories.addDormitories","Dormitories.list","Dormitories.delDorm","FeeDiscount.list","FeeDiscount.delFeeDiscount","FeeGroups.list","FeeGroups.delFeeGroup","FeeGroups.addFeeGroup","FeeGroups.editFeeGroup","FeeTypes.editFeeType","FeeTypes.delFeeType","FeeTypes.list","FeeTypes.addFeeType","Homework.Download","Homework.delHomework","Homework.list","Incomes.addIncome","Incomes.delIncome","Incomes.list","Incomes.editIncome","Incomes.incomeCategory","Invoices.Export","Invoices.collInvoice","Invoices.payRevert","Invoices.list","Polls.editPoll","Polls.addPoll","Polls.list","Polls.delPoll","Subjects.list","Subjects.addSubject","academicyears.list","classes.list","events.addEvent","events.delEvent","events.editEvent","events.list","frontendCMSpages.list","gradeLevels.list","mediaCenter.addAlbum","mediaCenter.addMedia","mediaCenter.editAlbum","mobileNotifications.sendNewNotification","newsboard.list","newsboard.editNews","newsboard.delNews","newsboard.addNews","sections.list","staffAttendance.takeAttendance","staffAttendance.attReport","staticPages.list","studyMaterial.list","studyMaterial.delMaterial","studyMaterial.editMaterial","Reports.Reports","Certificates.list","Certificates.del_cert","Certificates.add_cert","Certificates.edit_cert"]';
      $item->save();

      // 4
      $item = new Role;
      $item->role_title = 'Principal';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.addPage","academicyears.addAcademicyear","academicyears.editAcademicYears","academicyears.delAcademicYears","staticPages.editPage","staticPages.delPage","accountants.addAccountant","accountants.editAccountant","accountants.delAccountant","AccountSettings.ChgProfileData","AccountSettings.chgEmailAddress","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","classes.addClass","classes.editClass","classes.delClass","sections.addSection","sections.editSection","sections.delSection","Subjects.editSubject","Subjects.delSubject","newsboard.View","events.View","frontendCMSpages.addPage","frontendCMSpages.editPage","frontendCMSpages.delPage","mediaCenter.View","mediaCenter.delAlbum","mediaCenter.delMedia","mediaCenter.editMedia","gradeLevels.addLevel","gradeLevels.editGrade","gradeLevels.delGradeLevel","Promotion.promoteStudents","mailsms.mailSMSSend","mailsms.mailsmsTemplates","FeeDiscount.addFeeDiscount","FeeDiscount.editFeeDiscount","FeeDiscount.assignUser","Invoices.dueInvoices","Invoices.addPayment","Invoices.editPayment","Invoices.View","Invoices.delPayment","Assignments.Download","studyMaterial.addMaterial","studyMaterial.Download","Homework.addHomework","Homework.editHomework","Homework.View","Homework.Answers","Payroll.makeUsrPayment","Payroll.salaryBase","Payroll.hourSalary","Payroll.delUsrPayment","Payroll.userSalary","classSch.addSch","classSch.editSch","classSch.delSch","parents.AddParent","teachers.addTeacher","students.addStudent","examsList.addExam","examsList.examDetailsNot","examsList.showMarks","dashboard.stats","wel_office_cat.list","wel_office_cat.edit_cat","wel_office_cat.del_cat","wel_office_cat.View","wel_office_cat.add_cat","students.list","students.delStudent","students.stdLeaderBoard","students.Attendance","students.Marksheet","students.Import","students.listGradStd","students.editStudent","students.Approve","students.Export","students.medHistory","parents.list","parents.delParent","parents.Export","parents.Approve","parents.Import","parents.editParent","visitors.list","visitors.edit_vis","visitors.View","visitors.del_vis","visitors.add_vis","visitors.Download","visitors.Export","phn_calls.list","phn_calls.edit_call","phn_calls.View","phn_calls.del_call","phn_calls.Export","phn_calls.add_call","postal.list","postal.del_postal","postal.Download","postal.add_postal","postal.Export","postal.edit_postal","con_mess.list","con_mess.Export","con_mess.View","con_mess.del_mess","classSch.list","trans_vehicles.list","trans_vehicles.del_vehicle","trans_vehicles.Download","trans_vehicles.add_vehicle","trans_vehicles.edit_vehicle","teachers.EditTeacher","teachers.teacLeaderBoard","teachers.Export","teachers.Approve","teachers.list","teachers.delTeacher","teachers.Import","Transportation.members","Transportation.list","Transportation.delTrans","Transportation.addTransport","Transportation.editTransport","Hostel.HostelCat","Hostel.EditHostel","Hostel.listSubs","Hostel.AddHostel","Hostel.delHostel","Hostel.list","depart.list","depart.del_depart","depart.add_depart","depart.edit_depart","desig.list","desig.del_desig","desig.add_desig","desig.edit_desig","employees.list","employees.delEmployee","employees.addEmployee","employees.editEmployee","examsList.controlMarksExam","examsList.delExam","examsList.View","examsList.list","examsList.editExam","enquiries.list","enquiries.edit_enq","enquiries.Export","enquiries.del_enq","enquiries.View","enquiries.add_enq","enquiries.Download","complaints.edit_complaint","complaints.list","complaints.Export","complaints.del_complaint","complaints.View","complaints.Download","complaints.add_complaint","inv_cat.list","inv_cat.del_cat","inv_cat.add_cat","inv_cat.edit_cat","suppliers.list","suppliers.del_supp","suppliers.add_supp","suppliers.edit_supp","suppliers.Export","stores.list","stores.del_store","stores.add_store","stores.edit_store","items_code.list","items_code.del_item","items_code.Export","items_code.add_item","items_code.edit_item","items_stock.list","items_stock.del_item","items_stock.Download","items_stock.add_item","items_stock.edit_item","items_stock.Export","iss_ret.list","iss_ret.del_item","iss_ret.Download","iss_ret.issue_item","iss_ret.edit_item","iss_ret.Export","FeeAllocation.list","FeeAllocation.delFeeAllocation","FeeAllocation.addFeeAllocation","FeeAllocation.editFeeAllocation","onlineExams.QuestionsArch","onlineExams.delExam","onlineExams.list","onlineExams.takeExam","onlineExams.addExam","onlineExams.editExam","onlineExams.showMarks","issue_book.list","issue_book.del_issue","issue_book.add_issue","issue_book.Export","issue_book.edit_issue","issue_book.book_return","Library.mngSub","Library.editBook","Library.addBook","Library.Download","Library.delLibrary","Library.list","students.std_cat","students.admission","Expenses.list","Expenses.delExpense","Expenses.addExpense","Expenses.expCategory","Expenses.editExpense","Vacation.reqVacation","Vacation.appVacation","Vacation.myVacation","Attendance.takeAttendance","Attendance.attReport","Assignments.list","Assignments.delAssignment","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","Dormitories.editDorm","Dormitories.addDormitories","Dormitories.list","Dormitories.delDorm","FeeDiscount.list","FeeDiscount.delFeeDiscount","FeeGroups.list","FeeGroups.delFeeGroup","FeeGroups.addFeeGroup","FeeGroups.editFeeGroup","FeeTypes.editFeeType","FeeTypes.delFeeType","FeeTypes.list","FeeTypes.addFeeType","Homework.Download","Homework.delHomework","Homework.list","Incomes.addIncome","Incomes.delIncome","Incomes.list","Incomes.editIncome","Incomes.incomeCategory","Invoices.Export","Invoices.collInvoice","Invoices.payRevert","Invoices.list","Polls.editPoll","Polls.addPoll","Polls.list","Polls.delPoll","Subjects.list","Subjects.addSubject","academicyears.list","classes.list","events.addEvent","events.delEvent","events.editEvent","events.list","frontendCMSpages.list","gradeLevels.list","mediaCenter.addAlbum","mediaCenter.addMedia","mediaCenter.editAlbum","mobileNotifications.sendNewNotification","newsboard.list","newsboard.editNews","newsboard.delNews","newsboard.addNews","sections.list","staffAttendance.takeAttendance","staffAttendance.attReport","staticPages.list","studyMaterial.list","studyMaterial.delMaterial","studyMaterial.editMaterial","Reports.Reports","Certificates.list","Certificates.del_cert","Certificates.add_cert","Certificates.edit_cert"]';
      $item->save();

      // 5
      $item = new Role;
      $item->role_title = 'Teacher';
      $item->role_description = 'Default role for teachers';
      $item->def_for = 'teacher';
      $item->role_permissions = '["roles.list","Attendance.takeAttendance","Attendance.attReport","classes.list","Subjects.list","AccountSettings.ChgProfileData","AccountSettings.chgEmailAddress","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","newsboard.View","events.View","mailsms.mailSMSSend","mailsms.mailsmsTemplates","Assignments.Download","Homework.addHomework","Homework.editHomework","Homework.View","Homework.Answers","examsList.addExam","examsList.examDetailsNot","examsList.showMarks","classSch.list","trans_vehicles.list","depart.list","desig.list","examsList.controlMarksExam","examsList.delExam","examsList.View","examsList.list","examsList.editExam","Library.Download","Vacation.reqVacation","Vacation.myVacation","Assignments.list","Assignments.delAssignment","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","Homework.Download","Homework.delHomework","Homework.list","academicyears.list","classes.list","events.list","gradeLevels.list","mobileNotifications.sendNewNotification","studyMaterial.list","Library.list","Transportation.list","newsboard.list","studyMaterial.Download","studyMaterial.delMaterial","studyMaterial.addMaterial","studyMaterial.editMaterial","staticPages.list","mediaCenter.View","students.list","students.Attendance","students.delStudent","students.editStudent"]';
      $item->save();

      // 6
      $item = new Role;
      $item->role_title = 'Student';
      $item->role_description = 'Default role for students';
      $item->def_for = 'student';
      $item->role_permissions = '["students.TrackBus","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","newsboard.View","events.View","Homework.View","classSch.list","trans_vehicles.list","examsList.View","examsList.list","Library.Download","Vacation.myVacation","Homework.list","academicyears.list","events.list","gradeLevels.list","studyMaterial.list","Library.list","Transportation.list","newsboard.list","Homework.Download","Invoices.list","Invoices.View","Subjects.list","mediaCenter.View","Marksheet.Marksheet","myAttendance.myAttendance","Invoices.dueInvoices","Assignments.list","Assignments.Download","Assignments.applyAssAnswer","staticPages.list"]';
      $item->save();

      // 7
      $item = new Role;
      $item->role_title = 'Parents';
      $item->role_description = 'Default role for Parents';
      $item->def_for = 'parent';
      $item->role_permissions = '["mobileNotifications.sendNewNotification","students.TrackBus","studyMaterial.Download","classes.list","Subjects.list","AccountSettings.Messages","AccountSettings.myInvoices","AccountSettings.chgPassword","newsboard.View","events.View","Homework.View","classSch.list","trans_vehicles.list","examsList.View","examsList.list","Homework.list","events.list","gradeLevels.list","studyMaterial.list","Transportation.list","newsboard.list","Invoices.list","Invoices.View","mediaCenter.View","Marksheet.Marksheet","myAttendance.myAttendance","Invoices.dueInvoices","academicyears.list","students.list","students.Attendance","students.Marksheet","Homework.Answers","Homework.Download","Library.list","Polls.list","complaints.View","complaints.add_complaint","complaints.list","complaints.del_complaint","complaints.Download","complaints.edit_complaint","complaints.Export","Assignments.list","Assignments.Download","Assignments.applyAssAnswer","staticPages.list"]';
      $item->save();

      // 8
      $item = new Role;
      $item->role_title = 'Accountant';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.View","staticPages.list","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","Expenses.list","Expenses.delExpense","Expenses.addExpense","Expenses.expCategory","Expenses.editExpense","FeeAllocation.editFeeAllocation","FeeAllocation.addFeeAllocation","FeeAllocation.list","FeeAllocation.delFeeAllocation","FeeDiscount.list","FeeDiscount.delFeeDiscount","FeeDiscount.addFeeDiscount","FeeDiscount.assignUser","FeeDiscount.editFeeDiscount","FeeGroups.list","FeeGroups.delFeeGroup","FeeTypes.list","FeeTypes.delFeeType","FeeTypes.addFeeType","FeeGroups.addFeeGroup","FeeGroups.editFeeGroup","FeeTypes.editFeeType","Incomes.list","Incomes.delIncome","Incomes.addIncome","Incomes.incomeCategory","Incomes.editIncome","Invoices.addPayment","Invoices.collInvoice","Invoices.Export","Invoices.dueInvoices","Invoices.delPayment","Invoices.View","Invoices.list","Invoices.payRevert","Invoices.editPayment","dashboard.stats","newsboard.list","events.list"]';
      $item->save();

      // 9
      $item = new Role;
      $item->role_title = 'Librarian';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.View","staticPages.list","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","dashboard.stats","newsboard.list","events.list","Library.list","Library.delLibrary","Library.addBook","Library.Download","Library.editBook","Library.mngSub","issue_book.list","issue_book.del_issue","issue_book.add_issue","issue_book.Export","issue_book.edit_issue","issue_book.book_return"]';
      $item->save();

      // 10
      $item = new Role;
      $item->role_title = 'HR';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.View","staticPages.list","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","dashboard.stats","newsboard.list","events.list","Attendance.attReport","Attendance.takeAttendance","staffAttendance.attReport","staffAttendance.takeAttendance","Vacation.appVacation","employees.list","employees.addEmployee","employees.editEmployee","employees.delEmployee","enquiries.list","enquiries.edit_enq","enquiries.Export","enquiries.View","enquiries.del_enq","enquiries.Download","enquiries.add_enq","complaints.add_complaint","complaints.Download","complaints.del_complaint","complaints.View","complaints.edit_complaint","complaints.list","complaints.Export","Payroll.makeUsrPayment","Payroll.salaryBase","Payroll.delUsrPayment","Payroll.hourSalary","Payroll.userSalary"]';
      $item->save();

      // 11
      $item = new Role;
      $item->role_title = 'Receptionist';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.View","staticPages.list","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","dashboard.stats","newsboard.list","events.list","visitors.list","visitors.edit_vis","visitors.Export","visitors.del_vis","visitors.View","visitors.add_vis","visitors.Download","phn_calls.list","phn_calls.edit_call","phn_calls.View","phn_calls.del_call","phn_calls.add_call","phn_calls.Export","postal.Export","postal.edit_postal","postal.add_postal","postal.Download","postal.del_postal","postal.list","con_mess.list","con_mess.Export","con_mess.View","con_mess.del_mess","enquiries.add_enq","enquiries.Download","enquiries.del_enq","enquiries.View","enquiries.list","enquiries.edit_enq","enquiries.Export","complaints.list","complaints.edit_complaint","complaints.Export","complaints.del_complaint","complaints.View","complaints.add_complaint","complaints.Download"]';
      $item->save();

      // 12
      $item = new Role;
      $item->role_title = 'Store Keeper';
      $item->role_description = '';
      $item->def_for = 'none';
      $item->role_permissions = '["staticPages.View","staticPages.list","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","dashboard.stats","newsboard.list","events.list","stores.list","stores.del_store","stores.add_store","stores.edit_store","items_code.list","items_code.del_item","items_code.add_item","items_code.Export","items_code.edit_item","items_stock.edit_item","items_stock.Export","items_stock.Download","items_stock.add_item","items_stock.list","items_stock.del_item","iss_ret.del_item","iss_ret.list","iss_ret.issue_item","iss_ret.Download","iss_ret.edit_item","inv_cat.edit_cat","iss_ret.Export","inv_cat.add_cat","inv_cat.list","inv_cat.del_cat","suppliers.list","suppliers.del_supp","suppliers.add_supp","suppliers.edit_supp","suppliers.Export"]';
      $item->save();

      // 13
      $item = new Role;
      $item->role_title = 'Class Teacher';
      $item->role_description = '!!!!!!!!DO NOT REMOVE THIS ROLE !!!!!!!!ONLY MODIFYING PERMISSIONS IS ALLOWED';
      $item->def_for = 'none';
      $item->role_permissions = '["students.list","students.Attendance","studyMaterial.list","studyMaterial.addMaterial","studyMaterial.Download","studyMaterial.editMaterial","studyMaterial.delMaterial","AccountSettings.myInvoices","AccountSettings.chgPassword","AccountSettings.ChgProfileData","AccountSettings.Messages","AccountSettings.chgEmailAddress","Homework.Answers","Homework.list","Homework.editHomework","Homework.View","Homework.delHomework","Homework.addHomework","Homework.Download","Library.list","Library.Download","Transportation.list","Vacation.reqVacation","Vacation.myVacation","academicyears.list","classSch.list","classes.list","depart.list","desig.list","events.list","events.View","examsList.list","examsList.editExam","examsList.showMarks","examsList.View","examsList.delExam","examsList.controlMarksExam","examsList.addExam","examsList.examDetailsNot","gradeLevels.list","mailsms.mailSMSSend","mailsms.mailsmsTemplates","mobileNotifications.sendNewNotification","newsboard.list","newsboard.View","trans_vehicles.list","Attendance.takeAttendance","Attendance.attReport","Assignments.list","Assignments.delAssignment","Assignments.Download","Assignments.AddAssignments","Assignments.viewAnswers","Assignments.editAssignment","Assignments.applyAssAnswer","staticPages.list","mediaCenter.View","students.delStudent","students.editStudent"]';
      $item->save();

      // 14
      $item = new Role;
      $item->role_title = 'Media Coordinator';
      $item->role_description = 'Uploading, Editing and Deleting media';
      $item->def_for = '';
      $item->role_permissions = '["mediaCenter.View","mediaCenter.addAlbum","mediaCenter.editAlbum","mediaCenter.delAlbum","mediaCenter.addMedia","mediaCenter.editMedia","mediaCenter.delMedia"]';
      $item->save();
    }
}
