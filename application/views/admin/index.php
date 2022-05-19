<section class="home-section">
    <nav>
        <div class="sidebar-button">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="dashboard">Dashboard</span>
        </div>
    </nav>

    <div class="home-content">
        <div class="overview-boxes">
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Member</div>
                    <div class="number"><?= $this->user_model->get_data_user()->num_rows(); ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">Last update</span>
                    </div>
                </div>
                <i class='bx bxs-group cart icon'></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Room</div>
                    <div class="number">
                        <?php
                        $where = ['room_qty != 0'];
                        $totalstok = $this->kost_model->total(
                            'room_qty',
                            $where
                        );
                        echo $totalstok;
                        ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">Last update</span>
                    </div>
                </div>
                <i class='bx bx-bed cart icon'></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Total Area</div>
                    <div class="number"><?= $this->kost_model->get_data_kost()->num_rows(); ?></div>
                    <div class="indicator">
                        <i class='bx bx-up-arrow-alt'></i>
                        <span class="text">Last update</span>
                    </div>
                </div>
                <i class='bx bx-area cart icon'></i>
            </div>
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Managed by</div>
                    <div class="number">ASROG</div>
                    <div class="indicator">
                        <i class='bx bx-purchase-tag-alt'></i>
                        <span class="text">Web Programming II</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-payment">
            <div class="box">
                <div class="title">The last booking of this month</div>
                <p style="margin-bottom: 10px;">this booking table can be updated by clicking the booking menu.</p>
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Pay Date</th>
                            <th scope="col">Amount(Rp)</th>
                            <th scope="col">Status Payment</th>
                            <th scope="col">Status Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transaksi as $t) : ?>
                            <tr>
                                <td data-label="Name"><?= $t['name']; ?></td>
                                <td data-label="Start Date">
                                    <?= date('d F Y', strtotime($t['start_date'])); ?>
                                </td>
                                <td data-label="Pay Date">
                                    <?= date('d F Y', ($t['date_created'])); ?>
                                </td>
                                <td data-label="Amount"><?= number_format($t['price']); ?></td>
                                <td data-label="Status Payment">
                                    <?php if ($t['status'] !== '') : ?>
                                        <span class="badge badge-danger">Paid</span>
                                    <?php else : ?>
                                        <span class="badge badge-success">Unpaid</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Status Booking">
                                    <?= $t['status']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>