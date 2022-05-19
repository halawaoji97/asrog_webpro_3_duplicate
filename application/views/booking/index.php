<section class="home-section">
  <nav>
    <div class="sidebar-button">
      <i class='bx bx-menu sidebarBtn'></i>
      <span class="dashboard">Booking</span>
    </div>
  </nav>

  <div class="home-content">
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
              <th scope="col">Action</th>
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
                <td data-label="Action">
                  <a href="<?= base_url('transaction/confirm/') . $t['id']; ?>" class="btn btn-primary">Confirm</a>
                  <a href="<?= base_url('transaction/reject/') . $t['id']; ?>" class="btn btn-danger">Reject</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>