=== Work Time Allocator ===
Contributors: marsagnostics
Donate link: https://
Tags: time sheet, time tracker, reports, agency
Requires at least: 4.7
Tested up to: 5.6
Stable tag: 4.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Allocates working times to client jobs and generates reports

== Description ==

On the frontend it enables employees to track their times spent on client jobs. It only shows the employee's own times and
is limited to the last 10 records. The employee can also delete selected records. Jobs will only display open jobs
of the chosen client. 

The timetracker will only be shown to Users with the role of Employee or Administrator.

On the backend users can manage occupations, clients, and jobs. Adminstrators can also manage employees. 

In the options section users can chose the currency they are working with and privice email addresses where to 
send reports to.

Once a job is marked closed a pdf report will be generated and send to the email addresses provided in the options
section. These reports will give a brief overview of the job. Its duration, costs, the "regular" price on the
basis of the hours spent by the different occupations, marginal return and, if balanced by a monthly fee, the 
remaining budget.

These numbers are calculated on the basis of the information proviced in the different backend sections.

== Frequently Asked Questions ==

= Why do I have to define employees if I need to give the role 'Employee' to users first? =

To attribute further information to employees needed to calculate certain numbers for the report. The role
'Employee' ensures that you don't need to chose from the entire list of users. 

== Screenshots ==

1. Timetracker
2. Clients
3. Employees
4. Jobs
5. Occupations
6. Options

== Changelog ==

= 1.0 =
* This is the initial version

== Upgrade Notice ==

= 1.0 =
No upgrades available