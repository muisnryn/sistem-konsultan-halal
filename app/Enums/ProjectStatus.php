<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case PROFIL_COMPLETED = 'profil_completed';
    case PENGAJUAN_SUBMITTED = 'pengajuan_submitted';
    case WAITING_PAYMENT_T1 = 'waiting_payment_t1';
    case PAYMENT_T1_VERIFIED = 'payment_t1_verified';
    case CONSULTANT_ASSIGNED = 'consultant_assigned';
    case DOCUMENTS_VALID = 'documents_valid';
    case AUDIT_COMPLETED = 'audit_completed';
    case CERTIFICATE_ISSUED = 'certificate_issued';
    case WAITING_PAYMENT_T2 = 'waiting_payment_t2';
    case COMPLETED = 'completed';
}
