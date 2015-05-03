<?php
/**
 *  HE cPanel -- Hosting Engineers Control Panel
 *  Copyright (C) 2015  Dynamictivity LLC (http://www.hecpanel.com)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<!-- Plugin JS -->
<?php echo $this->Html->script('plugins/flot/jquery.flot'); ?>
<?php echo $this->Html->script('plugins/flot/jquery.flot.tooltip.min'); ?>
<?php echo $this->Html->script('plugins/flot/jquery.flot.pie'); ?>
<?php echo $this->Html->script('plugins/flot/jquery.flot.resize'); ?>

<!-- Plugin JS -->
<?php echo $this->Html->script('demos/flot/line'); ?>
<?php echo $this->Html->script('demos/flot/pie'); ?>
<?php echo $this->Html->script('demos/flot/auto'); ?>
<div class="row">
    <div class="col-md-4 col-sm-5">
        <div class="portlet">
            <h4 class="portlet-title">
                <u>Daily Stats</u>
            </h4>
            <div class="portlet-body">                
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, fugiat, dolores, laborum sit.</p>
                <hr>
                <table class="table keyvalue-table">
                    <tbody>
                        <tr>
                            <td class="kv-key"><i class="fa fa-dollar kv-icon kv-icon-primary"></i> Revenue</td>
                            <td class="kv-value">$5,367 </td>
                        </tr>
                        <tr>
                            <td class="kv-key"><i class="fa fa-gift kv-icon kv-icon-secondary"></i> Total Sales</td>
                            <td class="kv-value">473 </td>
                        </tr>
                        <tr>
                            <td class="kv-key"><i class="fa fa-exchange kv-icon kv-icon-tertiary"></i>Referrals</td>
                            <td class="kv-value">78</td>
                        </tr>
                        <tr>
                            <td class="kv-key"><i class="fa fa-envelope-o kv-icon kv-icon-default"></i> Inquiries</td>
                            <td class="kv-value">39 </td>
                        </tr>
                    </tbody>
                </table>
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div> <!-- /.col -->
    <div class="col-md-8 col-sm-7">
        <div class="portlet">
            <h4 class="portlet-title">
                <u>Monthly Traffic</u>
            </h4>
            <div class="portlet-body">
                <div id="line-chart" class="chart-holder-300"></div>
            </div> <!-- /.portlet-body -->          
        </div> <!-- /.portlet -->
    </div> <!-- /.col -->
</div> <!-- /.row -->
<div class="row">
    <div class="col-md-5">
        <div class="portlet">
            <h4 class="portlet-title">
                <u>Product Breakdown</u>
            </h4>
            <div class="portlet-body">
                <div id="pie-chart" class="chart-holder-250"></div>
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div> <!-- /.col -->
    <div class="col-md-3">
        <div class="portlet">
            <h4 class="portlet-title">
                <u>Progress Stats</u>
            </h4>
            <div class="portlet-body">
                <div class="progress-stat">
                    <div class="progress-stat-label">
                        % New Visits
                    </div>
                    <div class="progress-stat-value">
                        77.7%
                    </div>
                    <div class="progress progress-striped progress-sm active">
                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="77" aria-valuemin="0" aria-valuemax="100" style="width: 77%">
                            <span class="sr-only">77.74% Visit Rate</span>
                        </div>
                    </div> <!-- /.progress -->
                </div> <!-- /.progress-stat -->
                <div class="progress-stat">
                    <div class="progress-stat-label">
                        % Mobile Visitors
                    </div>
                    <div class="progress-stat-value">
                        33.2%
                    </div>
                    <div class="progress progress-striped progress-sm active">
                        <div class="progress-bar progress-bar-tertiary" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                            <span class="sr-only">33% Mobile Visitors</span>
                        </div>
                    </div> <!-- /.progress -->
                </div> <!-- /.progress-stat -->
                <div class="progress-stat">
                    <div class="progress-stat-label">
                        Bounce Rate
                    </div>
                    <div class="progress-stat-value">
                        42.7%
                    </div>
                    <div class="progress progress-striped progress-sm active">
                        <div class="progress-bar progress-bar-secondary" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                            <span class="sr-only">42.7% Bounce Rate</span>
                        </div>
                    </div> <!-- /.progress -->
                </div> <!-- /.progress-stat -->
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div> <!-- /.col -->
    <div class="col-md-4">
        <div class="portlet">
            <h4 class="portlet-title">
                <u>Server Load</u>
            </h4>
            <div class="portlet-body">
                <div id="auto-chart" class="chart-holder-200"></div>
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div> <!-- /.col -->
</div> <!-- /.row -->